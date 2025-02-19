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
	<!-- Sweetalert -->
	<script src="<?php echo base_url(); ?>src/build/js/sweetalert.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/build/css/sweetalert.css" />

	<link href="<?php echo base_url(); ?>src/build/css/select2.min.css" rel="stylesheet" />

	<style>
		.select2-dropdown {
			top: 0px !important;
			left: 0px !important;
		}

		div.polaroid {
			width: 80%;
			background-color: white;
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		.btn_on {
			position: fixed;
			bottom: 20px;
			right: 0;
			z-index: 1000;
		}

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

		td.fitwidth {
			padding: 0;
		}

		@media only screen and (max-width: 575px) {
			td.qr-code {
				display: none;
			}
		}

		body {}


		/* img {
			display: block;
			margin-left: auto;
			margin-right: auto;
			width: 100%;

		} */
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
						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->

			<div class="right_col" role="main">
				<div class="clearfix"></div>

				<div class="x_panel">
					<div class="x_title">
						<h2>
							<button class="btn btn-success collapse-link" type="button">Image</button>
							<a class="btn btn-success" onclick="window.history.back()">Go Back</a>
							<!--button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Lihat Surat Kuasa</button-->
							<br>
							<!--small>Silahkan isi form dibawah &raquo;</small-->
						</h2>
						<div class="clearfix">
						</div>
					</div>

					<div class="x_content collapse" style="width:100%;">
						<br />
						<img src="<?= base_url('upload/asset/' . $asset_list->pic) ?>" alt="">
						<!-- <?php echo "<img src='upload/asset/" . $asset_list->pic . "'>"; ?> -->
					</div>
				</div>

				<div class="x_panel">
					<div class="x_title">
						<h2>Asset Detail <small> Dataset</small></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<div class="">
								<table class="" width="100%">
									<tr>
										<td class="fitwidth">
											<label class="" for="first-name">Kode Asset <span class="required">*</span>
											</label>
										</td>
										<td>
											<?php echo $asset_list->kode; ?>
										</td class="fitwidth">
										<td rowspan="6" class="fitwidth qr-code">
											<div class="polaroid">
												<img src="<?php echo base_url(); ?>app/qrcode_view/<?php echo $asset_list->Id; ?>" alt="5 Terre" style="width:100%">
											</div>
										</td>
									<tr>
										<td class="fitwidth">
											<label class="" for="last-name">Nama Asset <span class="required">*</span>
											</label>
										</td>
										<td class="fitwidth"><?php echo $asset_list->nama_asset; ?></td>
									</tr>
									<tr>
										<td class="fitwidth">
											<label for="middle-name" class="">Spesifikasi</label>
										</td>
										<td class="fitwidth">
											<?php echo $asset_list->spesifikasi; ?>
										</td>
									</tr>
									<tr>
										<td class="fitwidth">
											<label for="middle-name" class="">Lokasi</label>
										</td>
										<td class="fitwidth">
											<?php echo $asset_list->lokasi; ?>
										</td>
									</tr>
									<tr>
										<td class="fitwidth">
											<label for="middle-name" class="">Ruangan</label>
										</td>
										<td class="fitwidth">
											<?php echo $asset_list->ruangan; ?>
										</td>
									</tr>
									<tr>
										<td class="fitwidth">
											<label class="">
												Tanggal Perolehan <span class="required">*</span>
											</label>
										</td>
										<td class="fitwidth">
											<?php
											$tgl = $asset_list->tgl_perolehan;
											echo date("d F Y", strtotime($tgl)); ?>
										</td>
									</tr>
									<tr>
										<td class="fitwidth">
											<label class="">
												Update Terakhir <span class="required">*</span>
											</label>
										</td>
										<td class="fitwidth">
											<?php $date = $asset_list->last_update;
											echo $newDate = date("d F Y", strtotime($date)); ?>
										</td>
									</tr>
									<tr>
										<td class="fitwidth">
											<label class="">
												Kondisi <span class="required">*</span>
											</label>
										</td>
										<td class="fitwidth">
											<?php
											if ($asset_list->kondisi == 1) {
												echo "Baik";
											} elseif ($asset_list->kondisi == 2) {
												echo "Rusak";
											} elseif ($asset_list->kondisi == 3) {
												echo "Dalam Perbaikan";
											} else {
												echo "";
											}
											?>
										</td>
									</tr>
								</table>

								<div class="item form-group">
									<div class="">
										<!--button class="btn btn-primary" type="button">Cancel</button>
										<button class="btn btn-primary" type="reset">Reset</button-->
										<button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1">Update</button>
									</div>
								</div>
								<!--div class="ln_solid"></div-->

							</div>
						</form>
					</div>
					<div class="x_panel">
						<div class="x_title">
							<h2>Asset History <small> Movement</small></h2>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
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
												<font color="white">Ruangan</font>
											</th>
											<th bgcolor="#004e81">
												<font color="white">Lokasi</font>
											</th>
											<th bgcolor="#004e81">
												<font color="white">Tanggal</font>
											</th>
											<th bgcolor="#004e81">
												<font color="white">Remarks</font>
											</th>
										</tr>
									</thead>
									<?php
									$no = 1;
									foreach ($asset_history as $data) :
									?>
										<!--content here-->
										<tbody>
											<tr>
												<td><?php echo $no; ?></td>
												<td><?php echo $data->kode; ?></td>
												<td><?php echo $data->ruangan; ?></td>
												<td><?php echo $data->lokasi; ?></td>
												<td><?php echo $data->tanggal; ?></td>
												<td><?php echo $data->remark; ?></td>
											</tr>
										</tbody>

									<?php
										$no++;
									endforeach;
									?>
								</table>
							</div>

						</div>
					</div>
				</div>


				<!-- Table -->
			</div>


			<!-- /page content -->
			<form data-parsley-validate enctype="multipart/form-data" action="<?php echo base_url(); ?>app/simpan_update" method="post" name="form_fullpayment" id="form_fullpayment" class="form-horizontal form-label-left">
				<div class="modal fade" id="myModal1" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h2 class="modal-title">Update Data Asset</h2>
							</div>
							<div class="modal-body">
								<h4>
									<font color="Grey"><Strong>
								</h4><br>
								<div class="form-group">
									<div class="item form-group">
										<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama
											Asset <span class="required">*</span>
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<input id="nama_asset" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="nama_asset" placeholder="" required="required" type="text" value="<?php echo $asset_list->nama_asset; ?>">
										</div>
										<br><br>
									</div>
								</div>
								<div class="form-group">
									<div class="item form-group">
										<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Foto
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<input id="nama_asset" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="foto_asset" placeholder="" type="file">
										</div>
										<br><br>
									</div>
								</div>
								<?php if (!file_exists(base_url('upload/asset/' . $asset_list->pic))) { ?>
									<div class="form-group">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Foto
												View <span class="required">*</span>
											</label>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<img src="<?= base_url('upload/asset/' . $asset_list->pic) ?>" alt="" width="100%">
											</div>
											<br><br>
										</div>
									</div>
								<?php } ?>
								<div class="form-group">
									<div class="item form-group">
										<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Spesifikasi <span class="required">*</span>
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<input id="spesifikasi" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="spesifikasi" placeholder="" required="required" type="text" value="<?php echo $asset_list->spesifikasi; ?>">
										</div>
										<br><br>
									</div>
								</div>
								<div class="form-group">
									<div class="item form-group">
										<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Ruangan <span class="required">*</span>
										</label>
										<!--div class="col-md-9 col-sm-9 col-xs-12">
					  <input id="ruangan" class="form-control col-md-7 col-xs-12" name="ruangan" placeholder="" required="required" type="text" value="<?php echo $asset_list->ruangan; ?>">
					</div-->

										<div class="col-md-9 col-sm-9 col-xs-12">
											<select class="js-example-basic-single" style="width:100%;" name="ruangan" id="ruangan" required="required">
												<?php foreach ($asset_ruang as $data) :
													if ($data->keterangan == $asset_list->ruangan) { ?>
														<option value="<?php echo $data->keterangan; ?>" selected>
															<?php echo $data->keterangan; ?></option>
													<?php } else { ?>
														<option value="<?php echo $data->keterangan; ?>">
															<?php echo $data->keterangan; ?></option>
													<?php } ?>
												<?php endforeach; ?>
											</select>
										</div>

										<br><br>
									</div>
								</div>
								<div class="form-group">
									<div class="item form-group">
										<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Lokasi <span class="required">*</span>
										</label>
										<!--div class="col-md-9 col-sm-9 col-xs-12">
					  <input id="lokasi" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="lokasi" placeholder="" required="required" type="text" 
					  value="<?php echo $asset_list->lokasi; ?>">
					</div-->

										<div class="col-md-9 col-sm-9 col-xs-12">
											<select class="form-control js-example-basic-single" style="width:100%;" name="lokasi" id="lokasi" required="required">
												<?php foreach ($asset_lokasi as $data) :
													if ($data->keterangan == $asset_list->lokasi) { ?>
														<option value="<?php echo $data->keterangan; ?>" selected>
															<?php echo $data->keterangan; ?></option>
													<?php } else { ?>
														<option value="<?php echo $data->keterangan; ?>">
															<?php echo $data->keterangan; ?></option>
													<?php } ?>
												<?php endforeach; ?>
											</select>
										</div>

										<br><br>
									</div>
								</div>
								<div class="form-group">
									<div class="item form-group">
										<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kondisi <span class="required">*</span>
										</label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<select class="form-control js-example-basic-single" style="width:100%;" name="kondisi" id="kondisi" required="required">
												<option value=""> -- Pilih Kondisi -- </option>
												<option value="1" <?= $asset_list->kondisi == 1 ? 'selected' : '' ?>>Baik</option>
												<option value="2" <?= $asset_list->kondisi == 2 ? 'selected' : '' ?>>Rusak</option>
											</select>
										</div>

										<br><br>
									</div>
								</div>
								<div class="form-group">
									<div class="item form-group">
										<label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Detail Perubahan <span class="required">*</span></label>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<textarea name="remark" class="form-control" rows="3" placeholder="Please write your information" required="required"></textarea>
										</div>
										<br><br><br><br>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<div style="text-align: center;">
									<input id="id_postf" name="id_postf" type="hidden" required="required" value="<?php echo $asset_list->Id; ?>">
									<input id="kode" name="kode" type="hidden" required="required" value="<?php echo $asset_list->kode; ?>">
									<?php
									echo form_submit('Submit', 'Simpan', 'onclick="return clicked();", class="btn btn-primary"');
									?>
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>

						</div>

					</div>
					<br><br><br>
				</div>
			</form>

			<!-- footer content -->

			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/jquery/dist/jquery.mask.js"></script>
	<script src="<?php echo base_url(); ?>src/build/js/select2.min.js"></script>
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
	<script src="<?php echo base_url(); ?>src/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js">
	</script>

	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/validator/validator.js"></script>

</body>
<script type="text/javascript">
	$(document).ready(function() {
		$('.js-example-basic-single').select2({
			dropdownParent: $('#myModal1 .modal-content')
		});

	});
	$("#tujuan").select2({
		placeholder: "Destination",
		allowClear: true
	});

	$('#myDatepicker').datetimepicker({
		format: 'YYYY-MM'
	});
</script>
<script>
	$('#myDatepicker2').datetimepicker({
		format: 'YYYY-MM',
	});

	function topFunction() {
		document.body.scrollTop = 0; // For Safari
		document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	}

	//sweet alert
	$('#btn-submit1').on('click', function(e) {
		e.preventDefault();
		var form = $(this).parents('form');
		swal({
			title: "Perhatian ?",
			text: "Cetak Slip Gaji !",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "iYes!",
			closeOnConfirm: false
		}, function(isConfirm) {
			if (isConfirm) form.submit();
			swal.close();
			//var form  = document.getElementById('form_input');//retrieve the form as a DOM element
			//var input = document.createElement('input');//prepare a new input DOM element
			//input.setAttribute('bulan_gaji_2', 'tes');//set the param name
			//form.appendChild(input);//append the input to the form
			//form.submit();//send with added input
		});
	});
</script>

</html>