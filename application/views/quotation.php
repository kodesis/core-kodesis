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

	<link href="<?php echo base_url(); ?>src/build/css/select2.min.css" rel="stylesheet" />

	<style>
		.select2-dropdown {
			top: 0px !important;
			left: 0px !important;
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
				<div class="">
					<div class="page-title" align="center">
						<font color="brown">Quotation</font><br>
						<div class="title_left">
							<h3></h3>
						</div>
					</div>
					<div class="clearfix">
					</div>
					<div class="x_panel">
						<div class="x_title">
							<h2>
								<button class="btn btn-success collapse-link" type="button">New Quotation</button>
								<!--button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Lihat Surat Kuasa</button-->
								<br>
								<!--small>Silahkan isi form dibawah &raquo;</small-->
							</h2>
							<ul class="nav navbar-right panel_toolbox">
								<!--li>
							 <a class="collapse-link">
							 <i class="fa fa-chevron-up">
							 </i>
							 </a>
						  </li>
						  <li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							 <i class="fa fa-wrench">
							 </i>
							 </a>
							 <ul class="dropdown-menu" role="menu">
								<li>
								   <a href="#">Settings 1
								   </a>
								</li>
								<li>
								   <a href="#">Settings 2
								   </a>
								</li>
							 </ul>
						  </li>
						  <li>
							 <a class="close-link">
							 <i class="fa fa-close">
							 </i>
							 </a>
						  </li-->
							</ul>
							<div class="clearfix">
							</div>
						</div>

						<div class="x_content collapse">
							<br />
							<?php echo form_open_multipart('app/', 'class="form-horizontal form-label-left" name="form_input" id="form_input"'); ?>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ktp">Product <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control" required="required">
										<option>Choose option</option>
										<option value="1">Port To Port</option>
										<option value="2">Door To Port</option>
									</select>
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Consignee <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="1" data-parsley-maxlength="200" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Shipper <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea id="message" required="required" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="1" data-parsley-maxlength="200" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"></textarea>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">NPWP <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input id="perihal" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="perihal" placeholder="" required="required" type="text">
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ktp">Origin <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control" required="required">
										<option>Choose option</option>
										<option value="1">CGK</option>
										<option value="2">HLP</option>
									</select>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ktp">Destination <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select id="tujuan" name="tujuan" style="width:100%">
										<option value="">Destination</option>
										<?php
										$no = 1;
										if (empty($tujuan)) {
										?>
											<?php
										} else {
											foreach ($tujuan as $data) :
											?>
												<option value="<?php echo $data->kode; ?>"><?php echo $data->nama_kota; ?></option>
										<?php endforeach;
										} ?>
									</select>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Airlines <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control" required="required">
										<option>Choose option</option>
										<option value="GA">GA - Garuda</option>
										<option value="QG">QG - Citilink</option>
										<option value="ID">ID - Batik Air</option>
										<option value="JT">JT - Lion Air</option>
										<option value="CAD">CAD - Cardig</option>
										<option value="6D">6D - Pelita Air</option>
									</select>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Comodity <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<select class="form-control" required="required">
										<option>Choose option</option>
										<option value="GA">Valuable Goods (VAL)</option>
										<option value="QG">Dangerous Good</option>
										<option value="ID">Vaccine</option>
										<option value="JT">Human Remain (HUM)</option>
										<option value="CAD">Live Animal</option>
										<option value="6D">Heavy Cargo</option>
										<option value="6D">Birdnest</option>
										<option value="6D">Overweight</option>
										<option value="6D">Strong Smell Goods</option>
										<option value="6D">Day Old chick</option>
										<option value="6D">Cut Flower</option>
										<option value="6D">Live Tropical Fish</option>
										<option value="6D">Handphone</option>
										<option value="6D">Perishable (PER,PEM,PES)</option>
										<option value="6D">Telur</option>
									</select>
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Surat <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class='input-group date' id='myDatepicker2'>
										<input type='text' name='date_pic1' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Terima Surat <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class='input-group date' id='myDatepicker3'>
										<input type='text' name='date_pic2' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
							</div>


							<div class="ln_solid"></div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button type="button" class="btn btn-round btn-danger collapse-link btn_on" onclick="topFunction()">&uarr;</button>
									<button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Cancel</button>
									<button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
									</button>
									<!--<button type="submit" id="save_project" name="save_project" class="btn btn-success" onclick="return clicked();">Submit</button>-->
									<button name="save_customer" id="btn-submit" type="submit" class="btn btn-success">Simpan</button><br><br><br>
									<!--<input type="submit" value="Save Customer" class="btn btn-success"/><br><br><br>-->
									<?php //echo form_submit('save_customer', 'Save Customer', 'onclick="return clicked();", class="btn btn-success"'); 
									?>
								</div>
							</div>
							</form>
						</div>
					</div>

					<!-- Table -->
					<div class="x_panel">
						<!--div class="alert alert-info">Daftar Surat Kuasa </div-->
						<div align="center">
							<font color="brown">Quotation List</font><br><br>
						</div>
						<!-- search -->
						<form data-parsley-validate action="<?php echo base_url(); ?>app/surat_masuk_cari" method="post" name="form_input" id="form_input">
							<label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
								<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-6 col-xs-8">
								<input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dari / perihal yang akan dicari">
							</div>
							<?php echo form_submit('cari_client', 'Cari', 'class="btn btn-primary"'); ?>
							<input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/surat_masuk'" />
						</form>

						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<tr>
										<th bgcolor="#004e81">
											<font color="white">ID</font>
										</th>
										<th bgcolor="#004e81">
											<font color="white">Dari</font>
										</th>
										<th bgcolor="#004e81">
											<font color="white">perihal</font>
										</th>
										<th bgcolor="#004e81">
											<font color="white">Tanggal</font>
										</th>
										<th bgcolor="#004e81">
											<font color="white">User Input</font>
										</th>
										<th bgcolor="#004e81">
											<font color="white">Detail</font>
										</th>
									</tr>
								</thead>
								<?php
								$no = 1;
								if (empty($users_data)) {
								?>

									<?php
								} else {
									foreach ($users_data as $data) :
									?>
										<!--content here-->
										<tbody>
											<tr>
												<td><?php echo $data->Id; ?></td>
												<td><?php echo $data->dari; ?></td>
												<td><?php echo $data->perihal; ?></td>
												<td><?php echo date('d-m-Y', strtotime($data->tanggal_surat)); ?></td>
												<td><?php echo $data->user_input; ?></td>
												<td>
													<form action="<?php echo base_url() . "app/viewfilepdf/" . $data->Id . '.pdf'; ?>" target="_blank">
														<button type="submit" class="btn btn-dark btn-xs">Lihat</button>
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
				</div>
			</div>


			<!-- /page content -->

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

	<!-- Custom Theme Scripts -->
	<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>
	<script src="<?php echo base_url(); ?>src/vendors/validator/validator.js"></script>

</body>
<script type="text/javascript">
	$("#tujuan").select2({
		placeholder: "Destination",
		allowClear: true
	});
</script>
<script>
	function topFunction() {
		document.body.scrollTop = 0; // For Safari
		document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	}
</script>

</html>