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

			<!-- Start content-->
			<div class="right_col" role="main" style="height: 100%;">
				<div class="clearfix"></div>

				<div class="x_panel card">
					<!--div class="alert alert-info">Daftar Surat Kuasa </div-->
					<div align="center">
						<font color="brown">Asset List </font><br><br>
					</div>
					<!-- search -->

					<form data-parsley-validate action="<?php echo base_url(); ?>app/asset_cari" method="post" name="form_input" id="form_input">
						<label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
							<span class="required">*</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-8">
							<input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="nama asset yang akan dicari">
						</div>
						<?php echo form_submit('cari_asset', 'Cari', 'class="btn btn-primary"'); ?>
						<input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/asset_list'" />
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1">Tambah Asset</button>
					</form>
					<form method="POST" action="<?= base_url('app/filter_jenis_asset') ?>" style="margin-bottom:20px;">
						<label class="control-label col-md-1 col-sm-1 col-xs-4">Filter Jenis</label>
						<div class="col-md-2 col-sm-2 col-xs-4">
							<select name="jenis" onchange="form.submit()" id="" class="form-control">
								<?php $jeniss = $this->session->userdata('filterJenis') ? $this->session->userdata('filterJenis') : '' ?>
								<option selected>Pilih Jenis</option>
								<option <?= $jeniss == '1' ? 'selected'  : '' ?> value="1">1</option>
								<option <?= $jeniss == '2' ? 'selected'  : '' ?> value="2">2</option>
								<option <?= $jeniss == '3' ? 'selected'  : '' ?> value="3">3</option>
								<option <?= $jeniss == '4' ? 'selected'  : '' ?> value="4">Mobil</option>
								<option <?= $jeniss == '5' ? 'selected'  : '' ?> value="5">ABK</option>
								<option <?= $jeniss == '99' ? 'selected'  : '' ?> value="99">IT</option>
							</select>
						</div>
						<a class="btn btn-warning" href="<?= base_url('app/reset_jenis') ?>">Reset</a>
						<a href="<?= base_url('app/export_asset') ?>" class="btn btn-success">Excel <i class="fa fa-file-excel-o"></i></a>

					</form>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th bgcolor="#004e81">
										<font color="white">No.</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Kode</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Nama</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Spesifikasi</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Ruang</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Lokasi</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Jns</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Jml</font>
									</th>
									<th bgcolor="#004e81">
										<font color="white">Detail</font>
									</th>
								</tr>
							</thead>
							<?php
							if (($this->uri->segment(2) == 'asset_cari') and ($this->uri->segment(3) <> '')) {
								$no = $this->uri->segment(4) + 1;
							} else {
								$no = $this->uri->segment(3) + 1;
							}
							if (empty($users_data)) {
							?>

								<?php
							} else {
								foreach ($users_data as $data) :
								?>
									<!--content here-->
									<tbody>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $data->kode; ?></td>
											<td><?php echo $data->nama_asset; ?></td>
											<td><?php echo $data->spesifikasi; ?></td>
											<td><?php echo $data->ruangan; ?></td>
											<td><?php echo $data->lokasi; ?></td>
											<td><?php echo $data->jenis_asset; ?></td>
											<td><?php echo $data->jumlah; ?></td>
											<td>
												<form action="<?php echo base_url() . "app/asset_detail/" . $data->Id; ?>" target="">
													<button type="submit" class="btn btn-dark btn-xs">View</button>
												</form>
											</td>

										</tr>
									</tbody>

							<?php
									$no++;
								endforeach;
							}
							?>
						</table>
					</div>

					<div class="clearfix"></div>

					<!--pagination-->
					<div class="row col-xs-12 text-center">
						<?php echo $pagination; ?>
					</div>
				</div>

				<!-- Finish content-->


				<!-- /page content -->
				<form data-parsley-validate enctype="multipart/form-data" action="<?php echo base_url(); ?>app/add_asset" method="post" name="form_fullpayment" id="form_fullpayment" class="form-horizontal form-label-left">
					<div class="modal fade" id="myModal1" role="dialog">
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h2 class="modal-title">Tambah Data Asset</h2>
								</div>
								<div class="modal-body">
									<h4>
										<font color="Grey"><Strong>
									</h4><br>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kode <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input id="kode" class="form-control col-md-12 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="kode" placeholder="" type="text">
											</div>
											<br><br>
										</div>
									</div>

									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Tgl Perolehan <span class="required">*</span></label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<div class='input-group date' id='myDatepicker'>
												<input type='text' id='date_pic' name='date_pic' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" />
												<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Jenis Asset <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select name="jenis_asset" class="form-control">
													<option>Pilih</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">Mobil</option>
													<option value="5">ABK</option>
													<option value="99">IT</option>
												</select>
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama Asset <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input id="nama_asset" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="nama_asset" placeholder="" type="text">
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Foto
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input id="foto_asset" class="form-control col-md-7 col-xs-12" name="foto_asset" placeholder="" type="file">
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Spesifikasi <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input id="spesifikasi" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="spesifikasi" placeholder="" type="text">
											</div>
											<br><br>
										</div>
									</div>

									<div class="form-group">
										<div class="item form-group">
											<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ruangan</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select class="form-control js-example-basic-single" style="width:100%;" name="ruangan" id="ruangan">
													<?php foreach ($asset_ruang as $data) : ?>
														<option value="<?php echo $data->keterangan; ?>"><?php echo $data->keterangan; ?></option>
													<?php endforeach; ?>
												</select>
											</div><br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lokasi</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select class="form-control js-example-basic-single" style="width:100%;" name="lokasi" id="lokasi">
													<?php foreach ($asset_lokasi as $data) : ?>
														<option value="<?php echo $data->keterangan; ?>"><?php echo $data->keterangan; ?></option>
													<?php endforeach; ?>
												</select>
											</div><br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Jumlah <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input id="jumlah" class="form-control col-md-7 col-xs-12" data-validate-length-range="1" data-validate-words="1" name="jumlah" placeholder="" type="number">
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="kondisi">Kondisi<span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select name="kondisi" class="form-control">
													<option value="1">Baik</option>
													<option value="2">Rusak</option>
													<option value="3">Dalam Perbaikan</option>
												</select>
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Harga <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<div class="input-group">
													<span class="input-group-addon">Rp
													</span>
													<input id="salary" class="uang form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="salary" placeholder="" type="text">
												</div>
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Umur <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<input id="jumlah" class="form-control col-md-7 col-xs-12" data-validate-length-range="1" data-validate-words="1" name="umur" placeholder="" type="number">
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="coa_asset">COA Asset<span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select name="coa_asset" class="form-control js-example-basic-single" style="width: 100%;">
													<option value=""> :: PILIH COA ASSET ::</option>
													<?php foreach ($coa_list as $cl) : ?>
														<option value="<?= $cl['no_sbb'] ?>"><?= $cl['no_sbb'] . ' - ' . $cl['nama_perkiraan'] ?></option>
													<?php endforeach ?>
												</select>
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="coa_beban">COA Beban<span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select name="coa_beban" class="form-control js-example-basic-single" style="width: 100%;">
													<option value=""> :: PILIH COA BEBAN ::</option>
													<?php foreach ($coa_list as $cl) : ?>
														<option value="<?= $cl['no_sbb'] ?>"><?= $cl['no_sbb'] . ' - ' . $cl['nama_perkiraan'] ?></option>
													<?php endforeach ?>
												</select>
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="coa_kas">COA Kas<span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select name="coa_kas" class="form-control js-example-basic-single" style="width: 100%;">
													<option value=""> :: PILIH COA KAS ::</option>
													<?php foreach ($coa_list as $cl) : ?>
														<option value="<?= $cl['no_sbb'] ?>"><?= $cl['no_sbb'] . ' - ' . $cl['nama_perkiraan'] ?></option>
													<?php endforeach ?>
												</select>
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="coa_penyusutan">COA Penyusutan<span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<select name="coa_penyusutan" class="form-control js-example-basic-single" style="width: 100%;">
													<option value=""> :: PILIH COA PENYUSUTAN ::</option>
													<?php foreach ($coa_list as $cl) : ?>
														<option value="<?= $cl['no_sbb'] ?>"><?= $cl['no_sbb'] . ' - ' . $cl['nama_perkiraan'] ?></option>
													<?php endforeach ?>
												</select>
											</div>
											<br><br>
										</div>
									</div>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Detail <span class="required">*</span></label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<textarea name="remark" class="form-control" rows="3" placeholder="Please write your information"></textarea>
											</div>
											<br><br><br><br>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<div>
										<button type="submit" class="btn btn-primary simpan">Simpan</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>

						</div>

					</div>
				</form>

				<!-- footer content -->

				<!-- /footer content -->

				<!-- jQuery -->
				<script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
				<script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.mask.js"></script>
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
				<!-- Select2 -->
				<link rel="stylesheet" href="<?php echo base_url(); ?>src/select2/css/select2.min.css">
				<script type="text/javascript" src="<?php echo base_url(); ?>src/select2/js/select2.min.js"></script>
				<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<!-- Custom Theme Scripts -->
				<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>

				<script>
					$('.select22').select2()
					$('#myDatepicker').datetimepicker({
						format: 'YYYY-MM-DD'
					});

					$(document).ready(function() {
						$('.js-example-basic-single').select2();
					});

					$(document).ready(function() {
						// Format mata uang.
						$('.uang').mask('000,000,000,000', {
							reverse: true
						});

						$('.simpan').click(function(e) {
							e.preventDefault();
							var parent = $(this).parents("form");
							var url = parent.attr("action");
							console.log(parent);
							var formData = new FormData(parent[0]);
							Swal.fire({
								title: "Are you sure?",
								text: "You want to submit the form?",
								icon: "warning",
								showCancelButton: true,
								confirmButtonColor: "#3085d6",
								cancelButtonColor: "#d33",
								confirmButtonText: "Yes",
							}).then((result) => {
								if (result.isConfirmed) {
									$.ajax({
										url: url,
										method: "POST",
										data: formData,
										processData: false,
										contentType: false,
										dataType: "JSON",
										beforeSend: () => {
											Swal.fire({
												title: "Loading....",
												timerProgressBar: true,
												allowOutsideClick: false,
												didOpen: () => {
													Swal.showLoading();
												},
											});
										},
										success: function(res) {
											if (res.success) {
												Swal.fire({
													icon: "success",
													title: `${res.msg}`,
													showConfirmButton: false,
													timer: 1500,
												}).then(function() {
													Swal.close();
													location.href = res.reload
												});
											} else {
												Swal.fire({
													icon: "error",
													title: `${res.msg}`,
													showConfirmButton: false,
													timer: 1500,
												}).then(function() {
													Swal.close();
												});
											}
										},
										error: function(xhr, status, error) {
											Swal.fire({
												icon: "error",
												title: `${error}`,
												showConfirmButton: false,
												timer: 1500,
											});
										},
									});
								}
							});
						})
					})
				</script>

</body>

</html>