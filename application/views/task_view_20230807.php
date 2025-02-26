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
	<title>BDL CORE | Business Development</title>
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

		.justify-content-center {
			display: flex;
			justify-content: center;
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
						<a href="<?php echo base_url(); ?>" class="site_title"><img src="<?php echo base_url(); ?>img/boc_logo.png" alt="..." height="42" width="60"><span> Bangun
								Desa</span></a>
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
					<!-- <strong>
						<font style="color:blue;font-size:24px;">BANDES</font>
						<font style="color:green;font-size:24px;">LOGISTIK</font>
					</strong></br>
					<font style="font-size:17px;">PT. Bangun Desa Logistindo</font></br></br>
					<br>
				 -->

					<?php if ($this->uri->segment(4) == false) { ?>
						<div align="center">
							<font style="font-size:17px;">
								Card List</br>
								<span class="btn btn-success"><?php
																echo $task->name; ?></span>
								<hr />
							</font>
						</div>
						<div class="col-md-4">
							<a href="<?= base_url('task/task') ?>" class="btn btn-warning"> <i class="fa fa-arrow-left"></i> Back</a>
							<?php
							$this->db->where('a.pic', $this->session->userdata('nip'));
							$this->db->join('task_detail as b', 'a.id=b.id_task');
							$cek_role = $this->db->get('task as a')->num_rows();

							$cek_status = $this->db->get_where('task', ['id' => $this->uri->segment(3)])->row_array();

							if ($cek_role == true && $cek_status['activity'] == '1') { ?>
								<a href="<?= base_url('task/detail_task/' . $this->uri->segment(3)) ?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Add Card</a>
							<?php } ?>
							<?php
							if ($cek_status['activity'] == '1' && $cek_role == true) { ?>
								<a href="<?= base_url('task/close_task/' . $this->uri->segment(3)) ?>" class="btn btn-danger"> Close Task</a>
							<?php } ?>
						</div>
					<?php } ?>
					<font style="font-size:14px;">
						<?php if ($this->uri->segment(3) == true && $this->uri->segment(4) == false) { ?>
							<div class="table-responsive">
								<table class="center table table-striped">
									<thead>
										<th>Card Name</th>
										<th>Responsible</th>
										<!-- <th>Description</th> -->
										<th>Start Date</th>
										<th>Due Date</th>
										<!-- <th>Attachment</th>  -->
										<th>Activity</th>
										<!-- <th>Comment</th> -->
										<th width="200">Action</th>
									</thead>
									<?php foreach ($task_detail as $x) {
										$nip = $this->session->userdata('nip');
										$kalimat = $x->read;
										if (preg_match("/$nip/i", $kalimat)) {
											if ($x->activity == '1' && $x->due_date > date('Y-m-d')) {
												$color = '#00b894';
											} else if ($x->activity == '3') {
												$color = '#636e72';
											} else {
												$color = '#ff7675';
											}

											if ($x->activity == '1') {
												$activity = 'Open';
											} else if ($x->activity == '2') {
												$activity = 'Pending';
											} else {
												$activity = 'Closed';
											}
									?>
											<tr style="background-color: <?= $color ?>;color:azure">
												<td> <?= $x->task_name ?></td>
												<td> <?= $x->nama ?></td>
												<td> <?= $x->start_date ?></td>
												<td> <?= $x->due_date ?></td>
												<td> <?= $activity ?></td>
												<td>
													<a href="<?= base_url('task/task_view/' . $this->uri->segment(3) . '/' . $x->id_detail) ?>" class="btn btn-xs" style="background-color: white;">Detail</a>
													<a href="<?= base_url('task/card_edit/' . $this->uri->segment(3) . '/' . $x->id_detail) ?>" class="btn btn-xs" style="background-color: black;color:white;">Edit</a>
												</td>
											</tr>
										<?php } else {
											if ($x->activity == '1') {
												$color = '#00b894';
											} else if ($x->activity == '2') {
												$color = '#0984e3';
											} else {
												$color = '#ff7675';
											}
											if ($x->activity == '1') {
												$activity = 'Open';
											} else if ($x->activity == '2') {
												$activity = 'Pending';
											} else {
												$activity = 'Closed';
											}
										?>
											<tr style="background-color: <?= $color ?>;color:azure">
												<td> <?= $x->task_name ?></td>
												<td> <?= $x->nama ?></td>
												<!-- <td> <?= $x->description ?></td> -->
												<td> <?= $x->start_date ?></td>
												<td> <?= $x->due_date ?></td>
												<!-- <td> <?= $x->attachment ?></td> -->
												<td> <?= $activity ?></td>
												<!-- <td> <?= $x->comment ?></td> -->
												<td>
													<a href="<?= base_url('task/task_view/' . $this->uri->segment(3) . '/' . $x->id_detail) ?>" class="btn btn-xs" style="background-color: white;">Detail</a>
													<i style="color: red;" class="fa fa-circle"></i>
												</td>
											</tr>
									<?php }
									} ?>

								</table>
							</div>
						<?php } else if ($this->uri->segment(4)) { ?>
							<div align="center">
								<font style="font-size:17px;">
									Card Detail</br>
									<span class="btn btn-success"><?php
																	echo $task_comment['task_name']; ?></span>
									<hr />
								</font>
							</div>
							<div class="item form-group" style="margin-bottom: 40px;">
								<div class="row">
									<div class="col-md-4">
										<a href="<?= base_url('task/task_view/' . $this->uri->segment(3)) ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
									</div>
								</div>
							</div>
							<div class="item form-group">
								<div class="row">
									<div class="col-md-2 col-sm-2 col-xs-4">
										<span>Task Name</span>
									</div>
									<div class="col-md-4">
										<b>: <?= $task_comment['task_name'] ?></b>

									</div>
								</div>
							</div>
							<div class="item form-group">
								<div class="row">
									<div class="col-md-2 col-sm-2  col-xs-4">
										<span>Responsible</span>
									</div>
									<div class="col-md-4 col-sm-6">
										<b>: <?= $task_comment['nama'] ?></b>
									</div>
								</div>
							</div>
							<div class="item form-group">
								<div class="row">
									<div class="col-md-2 col-sm-2  col-xs-4">
										<span>Description</span>
									</div>
									<div class="col-md-6">
										<b>: <?= $task_comment['description'] ?></b>
									</div>
								</div>
							</div>
							<div class="item form-group">
								<div class="row">
									<div class="col-md-2 col-sm-2  col-xs-4">
										<span>Start Date</span>
									</div>
									<div class="col-md-4">
										<b>: <?= $task_comment['start_date'] ?></b>
									</div>
								</div>
							</div>
							<div class="item form-group">
								<div class="row">
									<div class="col-md-2 col-sm-2  col-xs-4">
										<span>Due Date</span>
									</div>
									<div class="col-md-4">
										<b>: <?= $task_comment['due_date'] ?></b>
									</div>
								</div>
							</div>
							<?php if (count(explode(';', $task_comment['attachment'])) == true) { ?>
								<div class="item form-group">
									<div class="row">
										<div class="col-md-2 col-sm-2  col-xs-4">
											<span>Attachment</span>
										</div>
										<div class="col-md-8">
											:
											<?php $att_xx = explode(';', $task_comment['attachment']);
											foreach ($att_xx as $x) {
												if (file_exists('upload/task_comment/' . $x)) {
													$url = base_url('upload/task_comment/' . $x);
												} else {
													$url = base_url('upload/card_task/' . $x);
												}
											?>
												<a download href="<?= $url ?>"> <?= $x ?></a>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
							<?php if ($task_comment['responsible'] == $this->session->userdata('nip') || $task_comment['pic'] == $this->session->userdata('nip')) { ?>
								<?php if ($task_comment['activity'] != '3') { ?>
									<div class="item form-group">
										<div class="row">
											<div class="col-md-2 col-sm-2  col-xs-4">
												<span>Activity</span>
											</div>
											<div class="col-md-4 col-sm-8">
												<form action="<?= base_url('task/status_activity') ?>" method="POST" class="row">
													<input type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
													<input type="hidden" name="id_detail" value="<?= $this->uri->segment(4) ?>">
													<div class="col-md-5 col-sm-3">
														<select name="activity" id="" class="form-control">
															<?php if ($task_comment['activity'] === '1') { ?>
																<option selected value="1">Open</option>
																<option value="2">Pending</option>
																<option value="3">Closed</option>
															<?php } else if ($task_comment['activity'] == '2') { ?>
																<option value="1">Open</option>
																<option selected value="2">Pending</option>
																<option value="3">Closed</option>
															<?php } else if ($task_comment['activity'] == '3') { ?>
																<option value="1">Open</option>
																<option value="2">Pending</option>
																<option selected value="3">Closed</option>
															<?php } ?>
														</select>
													</div>
													<div class="col-sm-2">
														<button type="submit" class="btn btn-primary">Change</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								<?php } ?>

							<?php } ?>
							<hr>
							<div class="item form-group">
								<div class="row text-center">
									<h4> Activity</h4>
								</div>
							</div>
							<!-- <div class="item form-group"> -->
							<?php if ($task_comment['activity'] == "1") { ?>
								<form action="<?= base_url('task/activity_comment') ?>" method="POST" enctype="multipart/form-data">
									<div class="row justify-content-center">
										<input type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
										<input type="hidden" name="id_detail" value="<?= $this->uri->segment(4) ?>">
										<div class="col-md-8">
											<input style="border-radius: 20px;" type="file" name="file[]" class="form-control" multiple>
										</div>
									</div>
									<br>
									<div class="row justify-content-center">
										<div class="col-md-8">
											<input style="border-radius: 20px;" required name="commentt" type="text" class="form-control" placeholder="comment">
										</div>
									</div>
									<br>
									<div class="row justify-content-center">
										<div class="col-md-2">
											<button type="submit" class="btn btn-warning" style="width: 100%;border-radius:20px;">Add Activity</button>
										</div>
										<div class="col-md-6">

										</div>

									</div>
								</form>
							<?php } ?>

							<?php foreach ($task_comment_member as $x) {
								if ($x->member == $task_comment['responsible']) {
							?>
									<div class="row justify-content-center">
										<div class="col-md-8">
											<div style="margin-left: 20px;">
												<span style="font-size:14px;"> <?= date('d M Y H:i:s', strtotime($x->date_created)) ?></span>
											</div>
											<div class="x_panel tile fixed_height_300" style="background-color: #4CAF50;color:aliceblue;border-radius:20px;">
												<span>
													<div>
														<?= $x->nama ?>

														<b>: <?= $x->comment_member ?></b>
													</div>
												</span>
												<?php if ($x->attachment != null) { ?>
													<hr>
													Attachment :
													<b> <?php foreach (explode(';', $x->attachment_name) as $xx) {
															if (file_exists('upload/task_comment/' . $xx)) {
																$url2 = base_url('upload/task_comment/' . $xx);
															} else {
																$url2 = base_url('upload/card_task/' . $xx);
															}
														?>
															<a style="color: white;" href="<?= $url2 ?>" download>
																<?= $xx . " || " ?>
															</a>
													<?php }
													} ?>

													</b>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="row justify-content-center">
										<div class="col-md-8">
											<div style="margin-left: 20px;">
												<span style="font-size:14px;"> <?= date('d M Y H:i:s', strtotime($x->date_created)) ?></span>
											</div>
											<div class="x_panel tile fixed_height_300" style="background-color: #4287f5;color:aliceblue;border-radius:20px;">
												<span>
													<?= $x->nama ?>

													<b>: <?= $x->comment_member ?></b>
												</span>
												<?php if ($x->attachment != null) { ?>
													<hr>
													Attachment : <b> <?php foreach (explode(';', $x->attachment_name) as $x) {
																			if (file_exists('upload/task_comment/' . $x)) {
																				$url3 = base_url('upload/task_comment/' . $x);
																			} else {
																				$url3 = base_url('upload/card_task/' . $x);
																			}
																		?>
															<a style="color: white;" href="<?= $url3 ?>" download>
																<?= $x . " || " ?>
															</a>
													<?php }
																	} ?>
													</b>
											</div>
										</div>
									</div>
							<?php }
							} ?>
							<!-- <div class="row justify-content-center">
                        <div class="col-md-8">
                        <div  style="margin-left: 20px;">
                              <span style="font-size:14px;"> <?= date('d M Y H:i:s', strtotime($task_comment['date_created'])) ?></span>
                          </div>
                          <div class="x_panel tile fixed_height_300" style="background-color: #4CAF50;color:aliceblue;border-radius:20px;">
                              <div>
                                <span>
									<?= $task_comment['nama'] ?> :
                                    <b><?= $task_comment['comment'] ?> </b>
                                </span>
                              </div>
                          </div>
                         
                        </div>
                    </div> -->


							<!-- <div class="row justify-content-center"> -->

							<!-- </div> -->
							<!-- </div> -->
						<?php } ?>
						</br></br>


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