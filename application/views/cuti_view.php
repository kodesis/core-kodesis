<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />
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
	<link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link href="<?= base_url() ?>src/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>src/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>src/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>src/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>src/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
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

	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet" />

	<style>
		.column-title {
			background-color: #2980b9;
			color: white;
		}

		.btn_on {
			position: fixed;
			bottom: 20px;
			right: 0;
			z-index: 1000;
		}

		.col-xs-3 {
			width: 25%;
			background-color: #008080;
		}

		.container-fluid {
			padding-right: 0px;
			padding-left: 0px
		}

		.btn_footer_panel .tag_ {
			padding-top: 37px;
		}

		.colored-toast.swal2-icon-error {
			background-color: #f27474 !important;
			color: white;
		}

		.colored-toast.swal2-icon-success {
			background-color: #a5dc86 !important;
			color: white;
		}

		.colored-toast.swal2-icon-info {
			background-color: #3fc3ee !important;
		}

		.aksi {
			cursor: pointer;
		}

		.badge-success {
			background-color: green;
		}

		.badge-danger {
			background-color: red;
		}

		.badge-warning {
			background-color: orange;
		}

		th,
		td {
			padding: 5px;
		}
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
							<p color="white">Create</p>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/antrian_panggil">
						<i class="la-i la-i-m la-i-order"></i>
						<div class="tag_">
							<p color="white">Manage</p>
						</div>
					</a>
				</div>
				<div class="col-xs-3 btn_footer_panel">
					<a href="<?php echo base_url(); ?>app/antrian_monitor">
						<i class="la-i la-i-m la-i-notif">
						</i>
						<div class="tag_">
							<p color="white">Monitor</p>
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
						<a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>img/logo-kodesis.png" alt="..." height="42" width="60"><span>
								Kodesis</span></a>
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

			<div class="right_col" role="main">
				<div class="x_panel card">
					<div>
						<?php
						$nipSession = $this->session->userdata('nip');
						$user = $this->db->get_where('users', ['nip' => $nipSession])->row();

						$sql = ("SELECT COUNT(nip) as total FROM cuti WHERE status_atasan is null AND atasan = '$nipSession' AND nip != '$nipSession' AND 
						CASE 
						    WHEN cuti.jenis = 2 THEN status_hrd = 'Disetujui' AND cuti.atasan != cuti.dirsdm AND cuti.atasan != cuti.dirut
							ELSE status_hrd = 'Disetujui'
						END
						");
						$countAtasan = $this->db->query($sql)->row();

						$sql = ("SELECT COUNT(nip) as total FROM cuti WHERE status_hrd is null AND nip != '$nipSession'");
						$countHrd = $this->db->query($sql)->row();

						$sql = ("SELECT COUNT(nip) as total FROM cuti WHERE cuti.jenis = 2 AND cuti.status_dirsdm is null AND
						CASE 
							WHEN cuti.atasan = cuti.dirsdm THEN (cuti.status_hrd = 'Disetujui' OR cuti.status_atasan = 'Disetujui') 
							WHEN cuti.atasan = cuti.dirut THEN(cuti.status_hrd = 'Disetujui' OR cuti.status_atasan = 'Disetujui') 
							ELSE (cuti.status_hrd = 'Disetujui' AND cuti.status_atasan = 'Disetujui') END");
						$countDirsdm = $this->db->query($sql)->row();

						$sql = ("SELECT COUNT(nip) as total FROM cuti WHERE cuti.jenis = 2 AND cuti.status_dirut is null AND cuti.status_dirsdm = 'Disetujui' AND
						CASE 
							WHEN cuti.atasan = cuti.dirsdm THEN (cuti.status_hrd = 'Disetujui' OR cuti.status_atasan = 'Disetujui') 
							WHEN cuti.atasan = cuti.dirut THEN(cuti.status_hrd = 'Disetujui' OR cuti.status_atasan = 'Disetujui') 
							ELSE (cuti.status_hrd = 'Disetujui' AND cuti.status_atasan = 'Disetujui') END
						");

						$countDirut = $this->db->query($sql)->row();

						if ($user->level_jabatan == '5' && $user->bagian == '11') {
							$count = $countDirsdm->total;
						}

						if ($user->level_jabatan == '6') {
							$count = $countDirut->total;
						}

						?>

						<button class="btn btn-primary" data-toggle="modal" data-target="#cutiModal">
							<i class="fa fa-file-text-o" aria-hidden="true"></i> Form Cuti
						</button>

						<?php if ($user->bagian == '4') { ?>
							<a href="<?= base_url('cuti/data_approve_hrd_view') ?>" class="btn btn-success"><i class="fa fa-list-ul" aria-hidden="true"></i> Approval Hrd <span class="badge bg-red"><?= $countHrd->total > 0 ? $countHrd->total : "" ?></span></a>
						<?php } ?>
						<?php if ($user->level_jabatan >= '3') { ?>
							<a href="<?= base_url('cuti/data_approve_atasan_view') ?>" class="btn btn-success"><i class="fa fa-list-ul" aria-hidden="true"></i> Approval Atasan <span class="badge bg-red"><?= $countAtasan->total > 0 ? $countAtasan->total : "" ?></span></a>
						<?php } ?>
						<?php if (($user->level_jabatan == '5' && $user->bagian == '11') || $user->level_jabatan == '6') { ?>
							<a href="<?= base_url('cuti/data_approve_direksi_view') ?>" class="btn btn-success"><i class="fa fa-list-ul" aria-hidden="true"></i> Approval Direksi <span class="badge bg-red"><?= $count > 0 ? $count : "" ?></span></a>
						<?php } ?>
						<?php if ($user->level_jabatan == '4') { ?>
							<a href="<?= base_url('cuti/cuti_all') ?>" class="btn btn-success"><i class="fa fa-list-ul" aria-hidden="true"></i> List Cuti</a>
						<?php } ?>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade in active" id="all">
							<div class="table-responsive" style="margin-top: 2em;">
								<table id="table-all" class="table table-striped" width="100%">
									<thead>
										<tr class="headings">
											<th class="column-title">No.</th>
											<th class="column-title">Nama</th>
											<th class="column-title">Jenis Cuti</th>
											<th class="column-title">Alasan Cuti</th>
											<th class="column-title">Tanggal Pengajuan</th>
											<th class="column-title">Mulai Cuti</th>
											<th class="column-title">Jumlah Cuti</th>
											<th class="column-title">Atasan</th>
											<th class="column-title">Status</th>
											<th class="column-title">Aksi</th>
										</tr>
									</thead>
									<tbody id="cuti_all">

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Form Cuti User -->
	<div class="modal fade " id="cutiModal">
		<div class="modal-dialog modal-centered">
			<div class="modal-content">
				<!-- header-->
				<div class="modal-header">
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Form Pengajuan Cuti Online</h4>
				</div>
				<!--body-->
				<div class="modal-body">
					<form action="" id="formCuti" method="post">
						<div class="form-group">
							<label for="nama">Nama Karyawan</label>
							<input type="text" readonly class="form-control" placeholder="Nama Karyawan" id="nama" name="nama" value="<?= $this->session->userdata('nama') ?>">
						</div>
						<div class="form-group" id="error_jenis">
							<label for="jenisCuti">Jenis Cuti</label>
							<select class="form-control select2" id="jenisCuti" name="jenisCuti" style="width:100%;">
								<option value="">-- Pilih Jenis Cuti --</option>
								<?php foreach ($jenis_cuti as $row) : ?>
									<option value="<?= $row['Id'] ?>"><?= $row['nama_jenis'] ?></option>
								<?php endforeach ?>
							</select>
							<span id="err_jenis" class="text-danger"></span>
						</div>
						<div class="form-group error_detail" id="selectDetail">
							<label for="detailCuti">Detail Cuti</label>
							<select class="form-control select2" id="detailCuti" name="detailCuti" style="width: 100%;">
								<option value="">-- Detail Cuti --</option>
							</select>
							<span id="err_detail" class="text-danger"></span>
						</div>
						<div class="form-group" id="filePendukung">
							<label for="file">Dokumen Pendukung</label>
							<input type="file" class="form-control" id="file" name="file">
							<span id="err_file" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="alamat">Alamat Cuti</label>
							<textarea name="alamat" id="alamat" class="form-control"></textarea>
							<span id="err_alamat" class="text-danger"></span>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group" id="error_mulai">
									<label for="mulaiCuti">Dari</label>
									<div class="input-group date">
										<input type="text" class="form-control" placeholder="Mulai Cuti" id="mulaiCuti" name="mulaiCuti" onkeydown="event.preventDefault()" autocomplete="off">
										<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
									</div>
									<span id="err_mulai" class="text-danger"></span>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group" id="error_akhir">
									<label for="akhirCuti">Sampai</label>
									<div class="input-group date">
										<input type="text" class="form-control" placeholder="Akhir Cuti" id="akhirCuti" name="akhirCuti" onkeydown="event.preventDefault()" autocomplete="off">
										<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
									</div>
									<span id="err_akhir" class="text-danger"></span>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group" id="error_jumlah">
									<label for="jumlahCuti">Jumlah Cuti</label>
									<input type="text" class="form-control" placeholder="Jumlah Cuti" id="jumlahCuti" name="jumlahCuti" readonly>
									<span id="err_jumlah" class="text-danger"></span>
								</div>
							</div>
						</div>
						<div class="form-group" id="error_alasan">
							<label for="alasan">Alasan Cuti</label>
							<input type="text" class="form-control" placeholder="Alasan Cuti" id="alasan" name="alasan">
							<span id="err_alasan" class="text-danger"></span>
						</div>
						<div class="form-group">
							<label for="sisaCuti">Sisa Cuti Reguler</label>
							<?php $cuti = $this->db->get_where('users', ['nip' => $this->session->userdata('nip')])->row_array() ?>
							<input type="text" class="form-control" placeholder="Sisa cuti" id="sisaCuti" name="sisaCuti" value="<?= $cuti['cuti'] ?>" readonly>
						</div>
						<div class="form-group">
							<label for="atasan">Nama Atasan</label>
							<?php
							$nip_user = $this->session->userdata('nip');
							$user = $this->db->get_where('users', ['nip' => $nip_user])->row();
							$atasan = $this->db->get_where('users', ['nip' => $user->supervisi])->row();
							?>

							<input type="text" class="form-control" placeholder="Nama Atasan" id="atasan" name="atasan" value="<?= $atasan->nama ?>" readonly>
							<input type="hidden" class="form-control" placeholder="Nama Atasan" id="nipAtasan" name="nipAtasan" value="<?= $atasan->nip ?>" readonly>
						</div>
						<input type="hidden" name="nip" id="nip" value="<?= $this->session->userdata("nip") ?>">
						<!--footer-->
						<div class="modal-footer">
							<button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Tutup</button>
							<button type="button" class="btn btn-primary" id="btnSubmit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Detail Cuti -->
	<div class="modal fade " id="detail-cuti">
		<div class="modal-dialog modal-centered">
			<div class="modal-content">
				<!-- header-->
				<div class="modal-header">
					<button class="close" data-dismiss="modal"><span>&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Detail Cuti</h4>
				</div>
				<!--body-->
				<div class="modal-body">
					<table class="table" width="100%" id="detail-cuti-byID">

					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.mask.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Select2 -->
	<script src="<?php echo base_url(); ?>src/vendors/select2/dist/js/select2.min.js"></script>
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
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js">
	</script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>

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
	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/validator/validator.js"></script>
	<!-- Sweetalert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript">
		$(document).ready(() => {
			$('.select2').select2();

			var myTable = $('#table-all').DataTable({
				"ajax": {
					type: "POST",
					url: "<?= base_url('cuti/ambilDataCuti') ?>",
					data: function(d) {}
				},
			})

			<?php
			// $utility = $this->db->get('utility')->row_array();
			// $array = $utility['libur'];
			$this->db->order_by('tgl_libur', 'ASC');
			$utility = $this->db->get('libur')->result_array();
			$array = "";
			foreach ($utility as $value) {
				$array .= '"' . date('d/m/Y', strtotime($value['tgl_libur'])) . '",';
			}
			$array = "[" . rtrim($array, ',') . "]";
			?>

			let workingDaysBetweenDates = (d0, d1) => {
				/* Two working days and an sunday (not working day) */
				var holidays = <?= $array ?>;
				var startDate = parseDate(d0);
				var endDate = parseDate(d1);

				// Calculate days between date
				var time = endDate.getTime() - startDate.getTime();
				var days = (time / (1000 * 3600 * 24)) + 1;

				/* Here is the code */
				const tgl = [];
				holidays.forEach(day => {
					tgl.push(day);
				});
				const jml = [];
				for (var currentDate = new Date(startDate); currentDate <= new Date(endDate); currentDate.setDate(currentDate.getDate() + 1)) {
					tgl.find(function(item) {
						if (parseDate(item).getTime() == currentDate.getTime()) {
							jml.push(new Date(currentDate));
						}
					})

					// jika tanggal bertemu dengan sabtu atau minggu
					if (currentDate.getDay() == 0) {
						days = days - 1
					}

					if (currentDate.getDay() == 6) {
						days = days - 1
					}
				}

				days = days - jml.length

				return days
			}



			function parseDate(input) {
				// new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
				return new Date(input.split('/')[2], input.split('/')[1] - 1, input.split('/')[0])
			}


			// Fungsi menghitung antara 2 hari yang terpilih exclude weekends
			function getBusinessDays(dateObj, days) {
				const libur = [];
				var holi = <?= $array ?>;
				holi.forEach(day => {
					libur.push(new Date(day.split('/')[2], day.split('/')[1] - 1, day.split('/')[0]))
				});

				for (var i = 0; i < days; i++) {
					if (days > 0) {
						dateObj.setDate(dateObj.getDate() + 1)
						libur.forEach(element => {
							if (element.getTime() == dateObj.getTime()) {
								dateObj.setDate(dateObj.getDate() + 1)
							}

							if (dateObj.getDay() == 6 || dateObj.getDay() == 0) {
								dateObj.setDate(dateObj.getDate() + 2)
							}

							if (element.getTime() == dateObj.getTime()) {
								dateObj.setDate(dateObj.getDate() + 1)
							}
						})
					}

				}
				return dateObj;
			}

			$("#selectDetail").hide();
			$("#filePendukung").hide();
			// $("#akhirCuti").datepicker()
			// $("#mulaiCuti").datepicker()
			$("#jenisCuti").change(function() {
				$("#akhirCuti").datepicker('remove').prop('readonly', true);
				$("#mulaiCuti").datepicker('remove').prop('readonly', true);
				$("#mulaiCuti").val('');
				$("#akhirCuti").val('');
				$("#jumlahCuti").val('')
				var value = $(this).val();
				if (value > 0) {
					$.ajax({
						type: "POST",
						url: "<?= base_url('cuti/ambilDataDetail') ?>",
						cache: false,
						data: {
							id: value,
							cuti: 'user'
						},
						dataType: "JSON",
						success: function(res) {
							if (res.jenis.file_pendukung == 1) {
								$("#filePendukung").show();
								if (res.detail == 0) {
									$("#selectDetail").hide();
								} else {
									$("#selectDetail").show();
									$("#detailCuti").html(res.detail);
								}
							} else {
								$("#filePendukung").hide();
								if (res.detail == 0) {
									$("#selectDetail").hide();
								} else {
									$("#selectDetail").show();
									$("#detailCuti").html(res.detail);
								}
							}

							// JIka jenis cuti yang dipilih, cuti panjang
							if (res.jenis.Id == 2) {
								$('#mulaiCuti').removeAttr('readonly');
								$("#mulaiCuti").datepicker({
									autoclose: true,
									startDate: "+1m",
									format: 'dd/mm/yyyy'
								});
								$('#mulaiCuti').on('changeDate', (selected) => {
									const selesai = new Date(selected.date.valueOf());
									selesai.setMonth(selesai.getMonth() + 1);
									$("#akhirCuti").datepicker({
										autoclose: true,
										format: 'dd/mm/yyyy'
									}).datepicker('setDate', selesai);
									$("#akhirCuti").datepicker('remove').prop('readonly', true);
								})
								// Jika jenis cuti yang dipilih, cuti melahirkan
							} else if (res.jenis.Id == 3) {
								$('#mulaiCuti').removeAttr('readonly');
								$("#mulaiCuti").datepicker({
									autoclose: true,
									startDate: "+1m",
									format: 'dd/mm/yyyy'
								});
								$('#mulaiCuti').on('changeDate', (selected) => {
									const selesai = new Date(selected.date.valueOf());
									selesai.setMonth(selesai.getMonth() + 3);
									$("#akhirCuti").datepicker({
										autoclose: true,
										format: 'dd/mm/yyyy'
									}).datepicker('setDate', selesai);
									$("#akhirCuti").datepicker('remove').prop('readonly', true);
								})
							} else {
								if (res.detail == 0) {
									$('#mulaiCuti').removeAttr('readonly');
									var mulai = res.jenis.min_hari_pengajuan;
									var disabledWeekend = []

									res.jenis.Id == 4 || res.jenis.Id == 5 ?
										disabledWeekend = [] :
										disabledWeekend = [0, 6]

									mulai > 0 ?
										mulai = "+" + mulai + "d" :
										mulai = "now()"

									var max = res.jenis.max_hari;
									if (max > 0) {
										$("#mulaiCuti").datepicker({
											autoclose: true,
											startDate: "dateToday",
											daysOfWeekDisabled: disabledWeekend,
											datesDisabled: <?= $array ?>,
											format: 'dd/mm/yyyy'
										});
										$("#mulaiCuti").datepicker('setStartDate', mulai).on('changeDate', function(selected) {
											const minDate = new Date(selected.date.valueOf());
											minDate.setTime(minDate.getTime() + 3600 * 1000 * 24 * max - 1);
											$('#akhirCuti').datepicker({
												format: "dd/mm/yyyy"
											})
											$('#akhirCuti').datepicker('setDate', minDate);
											$("#akhirCuti").datepicker('remove').prop('readonly', true);
										});
									} else {
										var disabledWeekend = []
										res.jenis.Id == 4 || res.jenis.Id == 5 ?
											disabledWeekend = [] :
											disabledWeekend = [0, 6]

										$("#mulaiCuti").datepicker({
											autoclose: true,
											startDate: "dateToday",
											daysOfWeekDisabled: disabledWeekend,
											datesDisabled: <?= $array ?>,
											format: 'dd/mm/yyyy'
										});
										$("#mulaiCuti").datepicker('setStartDate', mulai).on('changeDate', function(selected) {
											$("#akhirCuti").removeAttr('readonly');
											const minDate = new Date(selected.date.valueOf());
											$("#akhirCuti").datepicker({
												todayBtn: true,
												todayHighlight: true,
												autoclose: true,
												daysOfWeekDisabled: disabledWeekend,
												datesDisabled: <?= $array ?>,
												format: 'dd/mm/yyyy'
											})
											$('#akhirCuti').datepicker('setStartDate', minDate)
										});
									}
								} else {
									var disabledWeekend = []
									res.jenis.Id == 4 || res.jenis.Id == 5 ?
										disabledWeekend = [] :
										disabledWeekend = [0, 6]

									$("#detailCuti").change(function() {
										$('#mulaiCuti').removeAttr('readonly');
										$("#mulaiCuti").val('');
										$("#akhirCuti").val('');
										$("#jumlahCuti").val('')
										var valueDetail = $(this).val();
										$.ajax({
											type: "POST",
											dataType: "JSON",
											url: "<?= base_url('cuti/dataDetail') ?>",
											cache: false,
											data: {
												idDetail: valueDetail
											},
											success: function(data) {
												var maxDate = data.jatahCuti;
												var start = data.min_hari_pengajuan;
												start > 0 ?
													start = "+" + start + "d" :
													start = "now()"

												if (maxDate > 0) {
													$("#mulaiCuti").datepicker({
														autoclose: true,
														startDate: "dateToday",
														daysOfWeekDisabled: disabledWeekend,
														datesDisabled: <?= $array ?>,
														format: 'dd/mm/yyyy'
													});
													$("#mulaiCuti").datepicker('setStartDate', start).on('changeDate', function(selected) {
														const minDate = new Date(selected.date.valueOf())
														$('#akhirCuti').datepicker({
															format: 'dd/mm/yyyy'
														})
														$('#akhirCuti').datepicker('setDate', getBusinessDays(minDate, maxDate - 1));
														$("#akhirCuti").datepicker('remove').prop('readonly', true);
													});
												} else {
													$("#mulaiCuti").datepicker({
														autoclose: true,
														startDate: "dateToday",
														daysOfWeekDisabled: disabledWeekend,
														datesDisabled: <?= $array ?>,
														format: 'dd/mm/yyyy'
													});
													$("#mulaiCuti").datepicker('setStartDate', start).on('changeDate', function(selected) {
														$("#akhirCuti").removeAttr('readonly');
														<?php
														$this->db->select("cuti");
														$data = $this->db->get_where('users', ['nip' => $this->session->userdata('nip')])->row_array();
														?>
														var jatah = <?= $data['cuti'] ?>;
														var startDate = new Date(selected.date.valueOf());
														const minDate = new Date(selected.date.valueOf());
														$("#akhirCuti").datepicker({
															todayBtn: true,
															todayHighlight: true,
															autoclose: true,
															daysOfWeekDisabled: disabledWeekend,
															datesDisabled: <?= $array ?>,
															format: 'dd/mm/yyyy'
														})
														$('#akhirCuti').datepicker('setStartDate', startDate)
													});
												}
											}
										})
									})
								}
							}
						}
					})
				}
			});

			$('#akhirCuti').change(function() {
				if ($("#jenisCuti").val() == 2 || $("#jenisCuti").val() == 3 || $("#jenisCuti").val() == 4 || $("#jenisCuti").val() == 5) {
					var awal = $('#mulaiCuti').val()
					awal = new Date(awal.split('/')[2], awal.split('/')[1] - 1, awal.split('/')[0])
					var akhir = $('#akhirCuti').val()
					akhir = new Date(akhir.split('/')[2], akhir.split('/')[1] - 1, akhir.split('/')[0])
					var time = akhir.getTime() - awal.getTime();
					var hari = (time / (1000 * 3600 * 24)) + 1;
					$('#jumlahCuti').val(hari);
				} else {
					var firstDate = $('#mulaiCuti').val();
					var secondDate = $('#akhirCuti').val();
					var jumlah = workingDaysBetweenDates(firstDate, secondDate)
					$('#jumlahCuti').val(jumlah == 0 ? 1 : jumlah);
				}
			})

			$('#mulaiCuti').change(function() {
				if ($("#jenisCuti").val() == 2 || $("#jenisCuti").val() == 3 || $("#jenisCuti").val() == 4 || $("#jenisCuti").val() == 5) {
					var awal = $('#mulaiCuti').val()
					awal = new Date(awal.split('/')[2], awal.split('/')[1] - 1, awal.split('/')[0])
					var akhir = $('#akhirCuti').val()
					akhir = new Date(akhir.split('/')[2], akhir.split('/')[1] - 1, akhir.split('/')[0])
					var time = akhir.getTime() - awal.getTime();
					var hari = (time / (1000 * 3600 * 24)) + 1;
					$('#jumlahCuti').val(hari);
				} else {
					var firstDate = $('#mulaiCuti').val();
					var secondDate = $('#akhirCuti').val();
					var jumlah = workingDaysBetweenDates(firstDate, secondDate)
					$('#jumlahCuti').val(jumlah == 0 ? 1 : jumlah);
				}
			})

			$('#btnSubmit').on('click', function() {
				var formData = new FormData($('#formCuti')[0]);
				$.ajax({
					url: "<?= base_url('cuti/sendCuti') ?>",
					type: "POST",
					data: formData,
					dataType: "JSON",
					processData: false,
					contentType: false,
					beforeSend: () => {
						Swal.fire({
							title: 'Sending...',
							timerProgressBar: true,
							allowOutsideClick: false,
							didOpen: () => {
								Swal.showLoading()
							},
						})
						$('#btnSubmit').attr('disabled', true)
					},
					complete: () => {
						$('#btnSubmit').attr('disabled', false)
					},
					success: function(res) {
						if (res.sukses) {
							Swal.fire({
								icon: 'success',
								title: res.msg,
								showConfirmButton: false,
							}, setTimeout(() => {
								location.reload();
							}, 2000))
						} else {
							Swal.fire({
								icon: 'error',
								title: res.msg,
								showConfirmButton: false,
							}, setTimeout(() => {
								Swal.close()
								res.err_jenis ? $("#err_jenis").html(res.err_jenis) : $("#err_jenis").html("");
								res.err_detail ? $("#err_detail").html(res.err_detail) : $("#err_detail").html("");
								res.err_mulai ? $("#err_mulai").html(res.err_mulai) : $("#err_mulai").html("");
								res.err_akhir ? $("#err_akhir").html(res.err_akhir) : $("#err_akhir").html("");
								res.err_jumlah ? $("#err_jumlah").html(res.err_jumlah) : $("#err_jumlah").html("");
								res.err_alasan ? $("#err_alasan").html(res.err_alasan) : $("#err_alasan").html("");
								res.err_alamat ? $("#err_alamat").html(res.err_alamat) : $("#err_alamat").html("");
								res.err_file ? $("#err_file").html(res.err_file) : $("#err_file").html("");
							}, 2000))
						}
					},
					error: function(xhr) {
						Swal.fire({
								icon: "error",
								title: `${xhr.responseJSON.message}`,
								showConfirmButton: false,
								allowOutsideClick: false,
							},
							setTimeout(function() {
								Swal.close();
							}, 1500)
						);
					},
				})
			})
		})

		function detailCuti(id) {
			$("#detail-cuti").modal('show');
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "<?= base_url('cuti/detailCuti/') ?>" + id,
				success: (res) => {
					$("#detail-cuti-byID").html(res);
				}
			})
		}

		function cetak(id) {
			window.open("<?= site_url('cuti/cetakPdf/') ?>" + id, "_blank")
		}

		function topFunction() {
			document.body.scrollTop = 0; // For Safari
			document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
		}
	</script>
</body>

</html>