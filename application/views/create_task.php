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

	<!-- CKEditor -->
	<script type="text/javascript" src="<?php echo base_url(); ?>src/ckeditor/ckeditor.js"></script>

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
									<li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out pull-right"></i> Log
											Out</a></li>
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
			<div class="right_col" role="main">
				<!--div class="pull-left">
				<font color='Grey'>Create New E-Memo </font>
			</div-->
				<div class="clearfix"></div>

				<!-- Start content-->
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel card">
							<div class="x_title">
								<h2>Create Task
								</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li>
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
									</li>
								</ul>
								<div class="clearfix">
								</div>
							</div>
							<div class="x_content">
								<br />

								<?php
								if ($this->uri->segment(3) == true) {
									echo form_open_multipart('task/update_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"');
								} else {
									echo form_open_multipart('task/save_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"');
								}
								?>
								<!-- <form action="<?= base_url('app/simpan_memo') ?>" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data"> -->
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Task Name</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php if ($this->uri->segment(3) == true) { ?>
											<input type="text" class="form-control" value="<?= $task_edit['name'] ?>" name="project_name" required style="border-radius: 5px;">
										<?php } else { ?>
											<input type="text" class="form-control" value="" name="project_name" required style="border-radius: 5px;">
										<?php } ?>
									</div>
								</div>
								<hr>
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Task Member</label>
									<!-- <div class="col-md6 col-sm-6 col-xs-12"> -->
									<?php if (!empty($this->uri->segment(4))) { ?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php if (!empty($memo->nip_kpd)) { ?>
												<select class="js-example-basic-multiple" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
													<?php foreach ($sendto as $data) : ?>
														<?php
														if (($data->nip == $memo->nip_dari)) { ?>
															<option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
														<?php } else { ?>
															<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
														<?php } ?>
													<?php endforeach; ?>
												</select>
											<?php } else { ?>
												<select class="js-example-basic-multiple" required="required" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
													<?php foreach ($sendto as $data) : ?>
														<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
													<?php endforeach; ?>
												</select>
											<?php } ?>
										</div>
									<?php } else { ?>
										<div class="col-md-6 col-sm-8 col-xs-12">
											<!--select class="form-control" required="required" multiple="multiple" name="member_task[]" id="member_task">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

											<?php if ($this->uri->segment(3) == true) { ?>
												<input type="hidden" name="id_edit" value="<?= $this->uri->segment(3) ?>">
												<select class="form-control js-example-basic-multiple" required="required" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
													<?php
													foreach ($sendto as $data) :
														if (strpos($task_edit['member'], $data->nip) !== false) {
													?>
															<option selected value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?>
																(<?php echo $data->nama_jabatan; ?>)</option>
														<?php
														} else { ?>
															<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?>
																(<?php echo $data->nama_jabatan; ?>)</option>

													<?php }
													endforeach; ?>
												</select>
											<?php } else { ?>
												<select class="form-control js-example-basic-multiple" required="required" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
													<?php foreach ($sendto as $data) : ?>
														<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?>
															(<?php echo $data->nama_jabatan; ?>)</option>
													<?php endforeach; ?>
												</select>
											<?php } ?>
										</div>
									<?php } ?>
									<!-- </div> -->
								</div>
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Task Activity</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php if ($this->uri->segment(3) == true) { ?>
											<select name="activity" id="" class="form-control" style="border-radius: 5px;">
												<option <?= $task_edit['activity'] == '1' ? 'selected' : '' ?> value="1">Open</option>
												<option <?= $task_edit['activity'] == '2' ? 'selected' : '' ?> value="2">Pending</option>
												<option <?= $task_edit['activity'] == '3' ? 'selected' : '' ?> value="3">Close</option>
											</select>
										<?php } else { ?>
											<select name="activity" id="" class="form-control" style="border-radius: 5px;">
												<option value="1">Open</option>
												<option value="2">Pending</option>
												<option value="3">Close</option>
											</select>
										<?php } ?>
									</div>
								</div>
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">
										Description</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<?php if ($this->uri->segment(3) == true) { ?>
											<textarea name="comment" id="comment" style="border-radius: 5px;" rows="4" class="form-control"><?= $task_edit['comment'] ?></textarea>
										<?php } else { ?>
											<textarea name="comment" id="comment" style="border-radius: 5px;" rows="4" class="form-control"></textarea>
										<?php } ?>

										<!-- <input style="border-radius: 5px;" type="text" class="form-control" name="comment"> -->
									</div>
								</div>



								<div class="form-group">
									<div class="col-md-6 col-sm-6 col-xs-12">

										<?php
										if ($this->uri->segment(3) == true) {
										?>
											<a class="btn btn-warning" href="<?= base_url('task/task') ?>">Back
											</a>
											<button id="submit-memo" type="submit" class="btn btn-success">Update Task</button><br>
										<?php } else { ?>
											<button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
											</button>
											<button id="submit-memo" type="submit" class="btn btn-success">Submit Task</button><br>
										<?php } ?>
									</div>
								</div>
								<br>
								</form>
							</div>
							</br>
							</br>
							</br>
						</div>
					</div>
				</div>
				<br><br>
				<!-- Finish content-->

			</div>

			<!-- /page content -->

			<!-- footer content -->

			<!-- /footer content -->
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
		<!-- Sweetalert -->
		<!-- <script src="<?php echo base_url(); ?>src/build/js/sweetalert.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>src/build/css/sweetalert.css" /> -->
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!-- Select2 -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>src/select2/css/select2.min.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>src/select2/js/select2.min.js"></script>

		<!-- Custom Theme Scripts -->
		<script src="<?php echo base_url(); ?>src/build/js/custom.min.js"></script>

		<script>
			function reset_form() {
				document.getElementById("form_input").reset();
				document.getElementById("ckeditor").value = '';
			}
			$(document).ready(function() {
				<?php
				if ($this->session->userdata('msg') == 'error2') {
				?>
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Error Input!',
					}) <?php
						$this->session->unset_userdata('msg');
					} else if ($this->session->userdata('msg_memo')) {
						?>
					Swal.fire({
						icon: 'success',
						title: 'Success input',
						text: 'Create & Send Success to ID <?php echo $this->session->userdata('
							msg_memo ') ?>',
					}) <?php
						$this->session->unset_userdata('msg_memo');
					} ?>
					$("#submit-memo").on('click', function(e) {
						if (!confirm('Are you sure that you want to submit the form')) {
							event.preventDefault();
						}

						// event.preventDefault();

					});
			});

			function simpan() {
				if (!confirm("Yes, send it!")) {
					alert('Canceled!');
					return false;
				} else {
					form.submit();
				}
			}

			$('#save_memo1').on('click', function(e) {
				e.preventDefault();
				var form = $(this).parents('form');
				swal({
					title: "Are you sure?",
					text: "Send Memo!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Yes, send it!",
					closeOnConfirm: false
				}, function(isConfirm) {
					if (isConfirm) form.submit();
				});
			});

			$(document).ready(function() {
				$('.js-example-basic-multiple').select2();
			});
		</script>

</body>

</html>