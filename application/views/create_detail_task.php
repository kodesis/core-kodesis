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
			background-color: #008080;
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
			<?php if ($this->uri->segment(4) != true) { ?>
				<div class="right_col" role="main">
					<!--div class="pull-left">
				<font color='Grey'>Create New E-Memo </font>
				</div-->
					<div class="clearfix"></div>

					<!-- Start content-->
					<?php echo form_open_multipart('task/save_detail_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"'); ?>

					<!-- <div class="row"> -->
					<!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
					<div class="x_panel card">
						<div class="x_title">
							<h2>Create Card
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
							<!-- <script>alert('Unauthorize Privilage!');window.history.back();</script> -->

							<a href="javascript:history.back()" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
							<br />
							<div class="task_array">
								<h4 class="text-center">Card</h4>
								<br>
								<input style="border-radius: 5px;" type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Name</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input style="border-radius: 5px;" type="text" class="form-control" name="project_name">
									</div>
								</div>
								<input style="border-radius: 5px;" type="hidden" value="1" name="row[]">
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Responsible</label>
									<!-- <div class="col-md6 col-sm-6 col-xs-12"> -->
									<div class="col-md-6 col-sm-6 col-xs-12">

										<select required style="border-radius: 5px;" class="form-control" name="member_task" required>
											<option value="">Select Responsible</option>
											<?php foreach ($ss as $data) {
												if ($data->nip != '') {
											?>
													<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<!-- </div> -->
								</div>

								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
									<div class="col-md6 col-sm-6 col-xs-12">
										<textarea style="border-radius: 5px;" type="text" class="form-control" name="description"></textarea>
									</div>
								</div>
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Start and due
										date</label>
									<div class="col-md-3 col-sm-6 col-xs-12">
										<input style="border-radius: 5px;" type="date" class="form-control" name="start">
									</div>
									<div class="col-md-3 col-sm-6 col-xs-12">
										<input style="border-radius: 5px;" type="date" class="form-control" name="end">
									</div>
								</div>
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
									<div class="col-md6 col-sm-6 col-xs-12">
										<input style="border-radius: 5px;" multiple type="file" name="att[]" class="form-control">
									</div>
								</div>

								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Activity</label>
									<div class="col-md6 col-sm-6 col-xs-12">
										<select style="border-radius: 5px;" class="form-control" name="activity" id="">
											<option value="1">Open</option>
											<option value="2">Pending</option>
											<option value="3">Close</option>
										</select>
									</div>
								</div>
								<!-- <div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Comment</label>
									<div class="col-md6 col-sm-6 col-xs-12">
										<textarea class="form-control" name="comment" id="comment1" style="border-radius: 5px;" type="text"></textarea>
									</div>
								</div> -->
							</div>

						</div>
						</br>
						</br>
						</br>
					</div>
					<input type="hidden" value="<?= $this->uri->segment(3) ?>" name="id_card">
					<!-- </div> -->
					<!-- </div> -->
					<div id="task_wrapper"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button class="btn btn-primary" type="reset" onclick="reset_form()">Reset</button>
							<button type="submit" class="btn btn-success">Create
								Card</button>
							<button type="button" id="add_task" class="btn btn-warning" style="display: none;">Add Card</button>
						</div>
					</div>
					</form>
					<br><br><br><br>

					<!-- Finish content-->

				</div>
			<?php } else { ?>
				<div class="right_col" role="main">
					<!--div class="pull-left">
					<font color='Grey'>Create New E-Memo </font>
					</div-->
					<div class="clearfix"></div>

					<!-- Start content-->
					<?php echo form_open_multipart('task/save_detail_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"'); ?>

					<!-- <div class="row"> -->
					<!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
					<div class="x_panel card">
						<div class="x_title">
							<h2>Edit Card
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
							<!-- <script>alert('Unauthorize Privilage!');window.history.back();</script> -->

							<a href="javascript:history.back()" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
							<br />
							<input type="hidden" name="status" value="edit">
							<?php foreach ($row_edit as $x) { ?>
								<div class="task_array">
									<h4 class="text-center">Card 1 </h4>
									<br>
									<input style="border-radius: 5px;" type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Name</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input value="<?= $x->task_name ?>" style="border-radius: 5px;" type="text" class="form-control" name="project_name">
										</div>
									</div>
									<input style="border-radius: 5px;" type="hidden" value="1" name="row[]">
									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Responsible</label>
										<!-- <div class="col-md6 col-sm-6 col-xs-12"> -->
										<div class="col-md-6 col-sm-6 col-xs-12">

											<select required style="border-radius: 5px;" class="form-control" name="member_task">
												<option value="">Select Responsible</option>
												<?php foreach ($ss as $data) {
													if ($data->nip != '') {
												?>
														<option <?= $x->responsible == $data->nip ? 'selected' : '' ?> value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
												<?php }
												} ?>
											</select>
										</div>
										<!-- </div> -->
									</div>

									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<textarea style="border-radius: 5px;" type="text" class="form-control" name="description"><?= $x->description ?></textarea>
										</div>
									</div>
									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Start and due
											date</label>
										<div class="col-md-3 col-sm-6 col-xs-12">
											<input style="border-radius: 5px;" type="date" value="<?= $x->start_date ?>" class="form-control" name="start">
										</div>
										<div class="col-md-3 col-sm-6 col-xs-12">
											<input style="border-radius: 5px;" type="date" value="<?= $x->due_date ?>" class="form-control" name="end">
										</div>
									</div>
									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
										<div class="col-md6 col-sm-3 col-xs-12">
											<input style="border-radius: 5px;" multiple type="file" name="att[]" class="form-control">
										</div>
										<div class="col-md6 col-sm-3 col-xs-12">
											<b> <?= $x->attachment == null ? 'File tidak ada' : $x->attachment ?></b>
										</div>

									</div>

									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Activity</label>
										<div class="col-md6 col-sm-6 col-xs-12">
											<select style="border-radius: 5px;" class="form-control" name="activity" id="">
												<option <?= $x->activity == '1' ? 'selected' : '' ?> value="1">Open</option>
												<option <?= $x->activity == '2' ? 'selected' : '' ?> value="2">Pending</option>
												<option <?= $x->activity == '3' ? 'selected' : '' ?> value="3">Close</option>
											</select>
										</div>
									</div>
									<!-- <div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Comment</label>
										<div class="col-md6 col-sm-6 col-xs-12">
											<textarea name="comment" id="comment1" class="form-control" style="border-radius: 5px;"><?= $x->comment ?></textarea>
										</div>
									</div> -->
								</div>
							<?php } ?>

						</div>
						</br>
						</br>
						</br>
					</div>
					<input type="hidden" value="<?= $this->uri->segment(3) ?>" name="id_task">
					<input type="hidden" value="<?= $this->uri->segment(4) ?>" name="id_card">
					<!-- </div> -->
					<!-- </div> -->
					<div id="task_wrapper"></div>
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button class="btn btn-primary" type="reset" onclick="reset_form()">Reset</button>
							<button type="submit" class="btn btn-success">Update
								Card</button>
							<!-- <button type="button" id="add_task" class="btn btn-warning">Add Card</button> -->
						</div>
					</div>
					</form>
					<br><br><br><br>

					<!-- Finish content-->

				</div>
			<?php } ?>
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
			var base_url = '<?= base_url() ?>';

			function reset_form() {
				document.getElementById("form_input").reset();
				document.getElementById("ckeditor").value = '';
			}
			$(document).ready(function() {
				<?php

				if ($this->session->flashdata('msg') == 'success_edit') { ?>
					Swal.fire({
						icon: 'success',
						title: 'success...',
						text: 'Update Card berhasil!',
					})
				<?php
				}
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
						text: 'Create & Send Success to ID <?php echo $this->session->userdata('msg_memo') ?>',
					});
				<?php
							$this->session->unset_userdata('msg_memo');
						} ?>
				$("#submit-memo").on('click', function(e) {
					if (!confirm('Are you sure that you want to submit the form')) {
						event.preventDefault();
					}

					// event.preventDefault();

				});
			});


			var max_fields = 100;
			var wrapper = $("#task_wrapper");
			var add_kom = $("#add_task");
			var x = 1;
			$(add_kom).click(function(e) {
				e.preventDefault();
				if (x < max_fields) {
					x++;
					$(wrapper).append(
						'<div class="x_panel card">' +
						'<h4 class="text-center">Card ' + x + '</h4>' +
						'<input style="border-radius: 5px;" type="hidden" value="' + x + '" name="row[]">' +
						'<div class="item form-group">' +
						'<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Task Name</label>' +
						'<div class="col-md-6 col-sm-12 col-xs-12">' +
						'<input style="border-radius: 5px;" type="text" class="form-control" name="project_name' + x + '" >' +
						'</div>' +
						'<button type="button" id="' + x + '" class="btn btn-danger remove_task">Remove Task</button>' +
						'</div>' +
						'<div class="item form-group">' +
						'<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Responsible Project</label>' +
						'<div class="col-md-6 col-sm-12 col-xs-12">' +
						'<select required style="border-radius: 5px;" class="form-control" id="member_task1' + x + '" name="member_task' + x + '" >' +
						'</select>' +
						'</div>' +
						'</div>' +
						'<div class="item form-group">' +
						'<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>' +
						'<div class="col-md-6 col-sm-12 col-xs-12">' +
						'<textarea style="border-radius: 5px;" type="text" class="form-control" name="description' + x + '" placeholder="" ></textarea>' +
						'</div>' +
						'</div>' +
						'<div class="item form-group">' +
						'<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Start and due date</label>' +
						'<div class="col-md-3 col-sm-12 col-xs-12">' +
						'<input style="border-radius: 5px;" type="date" class="form-control" name="start' + x + '" placeholder="" >' +
						'</div>' +
						'<div class="col-md-3 col-sm-12 col-xs-12">' +
						'<input style="border-radius: 5px;" type="date" class="form-control" name="end' + x + '" placeholder="" >' +
						'</div>' +
						'</div>' +
						'<div class="item form-group">' +
						'<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>' +
						'<div class="col-md-6 col-sm-12 col-xs-12">' +
						'<input style="border-radius: 5px;" type="file" class="form-control" multiple name="att' + x + '[]" placeholder="" >' +
						'</div>' +
						'</div>' +
						'<div class="item form-group">' +
						'<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Activity</label>' +
						'<div class="col-md-6 col-sm-12 col-xs-12">' +
						'<select style="border-radius: 5px;" class="form-control" name="activity' + x + '" >' +
						'<option value="1">Open</option>' +
						'<option value="2">Close</option>' +
						'<option value="3">Pending</option>' +
						'</select>' +
						'</div>' +
						'</div>' +
						'<div class="item form-group">' +
						'<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Comment</label>' +
						'<div class="col-md-6 col-sm-12 col-xs-12">' +
						'<input style="border-radius: 5px;" type="text" class="form-control" name="comment' + x + '" placeholder="" >' +
						'</div>' +
						'</div>' +
						'</div>'
					);

					//bentuk

					var bentukAppend2 = '';
					bentukAppend2 += '<option disabled selected>Select Responsible</option>';
					<?php foreach ($ss as $x) {
						if ($x->username != '') {
					?>
							bentukAppend2 += '<option value="<?= $x->nip ?>"><?= $x->nama ?></option>';
					<?php }
					} ?>
					$('#member_task1' + x).append(bentukAppend2);
					// $.ajax({
					//     url: "<?= base_url() ?>task/get_detail_task",
					//     type: "GET",
					//     dataType: "html",
					//     success: function (respons) {
					//         var obj_respons = JSON.parse(respons)
					// 		bentukAppend2 += '<option disabled selected>Select Responsible</option>';
					//         $.each(obj_respons,function(i,item){
					// 			if (item.username != '') {
					//             	bentukAppend2 += '<option value="'+item.nip+'">'+item.nama+'</option>';
					// 			}
					//         });
					//         $('#member_task1'+x).append(bentukAppend2);
					//     }
					// })
					// var mediaAppend2 = '';
					// $.ajax({
					//     url: base_url + "permohonan/getMedia",
					//     type: "GET",
					//     dataType: "html",
					//     success: function (respons) {
					//         var obj_respons = JSON.parse(respons)
					//         $.each(obj_respons,function(i,item){
					//             mediaAppend2 += '<option value="'+item.nama+'">'+item.nama+'</option>';
					//         });
					//         $('#media'+x).append(mediaAppend2);
					//     }
					// })

					$('.add-target').on('click', function(e) {
						e.preventDefault();
						var tid = this.id;
						var unik = $('#unik').val();
						var sid = $(this).parent('div').parent('div').find('#id' + tid).val();
						var cname = $(this).parent('div').parent('div').find('#common_name' + tid).val();
						var lname = $(this).parent('div').parent('div').find('#latin_name' + tid).val();
						var bname = $(this).parent('div').parent('div').find('#bentuk' + tid).val();
						var mname = $(this).parent('div').parent('div').find('#media' + tid).val();

						$("#target_id").val(tid);
						var act = '';
						if (tid > 100) {
							$("#submit_target_form").val('Update');
							act = 'update';
						} else {
							$("#submit_target_form").val('Submit');
							act = 'insert';
						}

						if (cname) {
							$("#myModalLabel").html('Target Uji (' + cname + ')');
							$.post(base_url + "permohonan/load_target_form", {
								target_id: tid,
								act: act,
								unik: unik,
								cname: cname,
								lname: lname,
								bname: bname,
								mname: mname
							}, function(data) {
								//console.log(data);
								$(".mdl-targetModal").html(data).show();
								$("#target_form")[0].reset();
								$('input.flat').iCheck({
									checkboxClass: 'icheckbox_flat-green',
									radioClass: 'iradio_flat-green'
								});
								$(".select2_multiple").select2({
									maximumSelectionLength: 10,
									placeholder: "Pilih",
									allowClear: true,
									width: '100%',
									dropdownParent: $("#targetModal")
								});
								load_cb_target();
							})
						} else {
							//alert('Isikan Common Name!');
							Swal.fire({
								type: 'error',
								title: 'Isikan Nama Contoh Uji!'
							});
							$(this).parent('div').parent('div').find('#common_name' + tid).focus();
							return false;
						}
					});

				}

			});

			$(wrapper).on('click', '.remove_task', function(e) {
				// console.log(x)
				e.preventDefault();
				$(this).parent('div').parent('div').remove();
				x--;

				// console.log($(this).parent('div').parent('div'));

				// Removing the current row.
				// $(this).closest('tr').remove();

				// Decreasing the total number of rows by 1.
				// rowIdx--;
			});
			// $(wrapper).on('click', '.remove_task', function (){
			// 	// var id = this.id;
			// 	console.log($(this).parent('div').parent('div'))
			// 	// var split_id = id.split("_");
			// 	// var deleteindex = split_id[1];

			// 	// Hapus <div> dengan id
			// 	// $("#div_" + deleteindex).remove();
			// 	// $(this).parent('div').parent('div').remove(); x--;
			// });
		</script>

</body>

</html>