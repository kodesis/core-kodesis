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

				<div class="x_panel card">
					<div class="page-title" align="center">
						<font color="brown">Upload Gaji (Monthly)</font><br>
						<div class="title_left">
							<h3></h3>
						</div>
					</div>

					<div class="row">
						<form method="POST" id="form_input" name="form_input" action="<?php echo base_url() ?>app/upload_gaji" enctype="multipart/form-data">
							<!--div class="form-group">
						<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Bulan Gaji <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class='input-group date' id='myDatepicker'>
								<input type='text' id='bulan_gaji' name='bulan_gaji' class="form-control" placeholder="yyyy-mm" data-validate-words="1" required="required"/>
								<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div-->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<?php echo $this->session->flashdata('notif') ?>
								<div class="form-group">
									<label for="exampleInputEmail1">UNGGAH FILE EXCEL</label>
									<input type="file" accept=".xlsx,application/msexcel" name="userfile" class="form-control">
								</div>
								<!--button type="submit" class="btn btn-success">UPLOAD</button-->
								<button name="btn-submit" id="btn-submit" type="button" class="btn btn-success">Upload</button><br>
							</div>
						</form>
					</div>

				</div>

				<div class="x_panel card">
					<div class="page-title" align="center">
						<font color="brown">Upload Gaji (Daily)</font><br>
						<div class="title_left">
							<h3></h3>
						</div>
					</div>

					<div class="row">
						<form method="POST" id="form_input2" name="form_input2" action="<?php echo base_url() ?>app/upload_gaji2" enctype="multipart/form-data">
							<!--div class="form-group">
						<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Bulan Gaji <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class='input-group date' id='myDatepicker'>
								<input type='text' id='bulan_gaji' name='bulan_gaji' class="form-control" placeholder="yyyy-mm" data-validate-words="1" required="required"/>
								<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div-->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<?php echo $this->session->flashdata('notif2') ?>
								<div class="form-group">
									<label for="exampleInputEmail1">UNGGAH FILE EXCEL</label>
									<input type="file" accept=".xlsx,application/msexcel" name="userfile" class="form-control">
								</div>
								<!--button type="submit" class="btn btn-success">UPLOAD</button-->
								<button name="btn-submit2" id="btn-submit2" type="button" class="btn btn-success">Upload</button><br>
							</div>
						</form>
					</div>

				</div>

				<!-- Table -->
			</div>


			<!-- /page content -->

			<!-- footer content -->

			<!-- /footer content -->


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
			<script src="<?php echo base_url(); ?>src/vendors/validator/validator.js"></script>

</body>
<script type="text/javascript">
	$("#tujuan").select2({
		placeholder: "Destination",
		allowClear: true
	});

	$('#myDatepicker').datetimepicker({
		format: 'YYYY-MM'
	});
</script>
<script>
	function topFunction() {
		document.body.scrollTop = 0; // For Safari
		document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	}

	//sweet alert
	$('#btn-submit').on('click', function(e) {
		e.preventDefault();
		var form = $(this).parents('form');
		swal({
			title: "Perhatian ?",
			text: "Data gaji akan diupload !",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Upload!",
			closeOnConfirm: false
		}, function(isConfirm) {
			if (isConfirm) form.submit();
			//var form  = document.getElementById('form_input');//retrieve the form as a DOM element
			//var input = document.createElement('input');//prepare a new input DOM element
			//input.setAttribute('bulan_gaji_2', 'tes');//set the param name
			//form.appendChild(input);//append the input to the form
			//form.submit();//send with added input
		});
	});
	$('#btn-submit2').on('click', function(e) {
		e.preventDefault();
		var form = $(this).parents('form');
		swal({
			title: "Perhatian ?",
			text: "Data gaji akan diupload !",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, Upload!",
			closeOnConfirm: false
		}, function(isConfirm) {
			if (isConfirm) form.submit();
		});
	});
</script>

</html>