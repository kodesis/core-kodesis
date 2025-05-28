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
								<h2>Create New Digital Memo
									<small>Please fill below
									</small>
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
								<?php echo form_open_multipart('app/simpan_memo', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"'); ?>
								<!-- <form action="<?= base_url('app/simpan_memo') ?>" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data"> -->
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tujuan KOC <span class="required"> *</span></label>
									<?php if (!empty($this->uri->segment(4))) { ?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<?php if (!empty($memo->nip_kpd)) { ?>
												<select class="form-control js-example-basic-multiple" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple">
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
												<select class="form-control js-example-basic-multiple" required="required" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple">
													<?php foreach ($sendto as $data) : ?>
														<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
													<?php endforeach; ?>
												</select>
											<?php } ?>
										</div>
									<?php } else { ?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!--select class="form-control" required="required" multiple="multiple" name="tujuan_memo[]" id="tujuan_memo">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

											<?php if (!empty($memo->nip_kpd)) { ?>
												<select class="form-control js-example-basic-multiple" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple">
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
												<select class="form-control js-example-basic-multiple" required="required" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple">
													<?php foreach ($sendto as $data) : ?>
														<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?> (<?php echo $data->nama_jabatan; ?>)</option>
													<?php endforeach; ?>
												</select>
											<?php } ?>
										</div>
									<?php } ?>
								</div>

								<?php if (!empty($this->uri->segment(4))) { ?>
									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CC KOC</label>
										<div class="col-md-6 col-sm-6 col-xs-12">

											<select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
												<?php foreach ($sendto as $data) : ?>
													<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>

								<?php } else { ?>
									<div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CC KOC</label>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<!--select class="form-control" multiple="multiple" name="cc_memo[]" id="cc_memo">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

											<?php if (!empty($memo->nip_cc)) { ?>
												<!-- <?= $memo->nip_kpd ?>       -->
												<?php foreach ($sendto as $data) : ?>
												<?php
												// $o = explode(';',$memo->nip_kpd);
												// echo  var_dump($o);
												// echo $data->nip;
												// if (strpos($memo->nip_cc,$data->nip) !== false) {
												// 	// if($data->nip<>$this->session->userdata('nip')){
												// 		echo $data->nama;
												// 	// }
												// }else if(strpos($memo->nip_cc,$data->nip) !== false){
												// 	echo $data->nama;
												// } 
												endforeach;
												?>
												<select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
													<?php foreach ($sendto as $data) : ?>
														<?php if (strpos($memo->nip_cc, $data->nip) !== false) {
															if ($data->nip <> $this->session->userdata('nip')) { ?>
																<option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
															<?php } ?>
															<?php } elseif (strpos($memo->nip_kpd, $data->nip) !== false) {
															if ($data->nip <> $this->session->userdata('nip')) { ?>
																<option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
															<?php } ?>
														<?php } else { ?>
															<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
														<?php } ?>
													<?php endforeach; ?>
												</select>
											<?php } else if (empty($memo->nip_cc) && $this->uri->segment(3)) { ?>
												<select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
													<?php foreach ($sendto as $data) : ?>
														<?php if (strpos($memo->nip_kpd, $data->nip) !== false) {
															if ($data->nip <> $this->session->userdata('nip')) {
														?>
																<option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
														<?php }
														} ?>
														<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?> (<?php echo $data->nama_jabatan; ?>)</option>
													<?php endforeach; ?>
												</select>
											<?php } else { ?>
												<select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
													<?php foreach ($sendto as $data) : ?>
														<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?> (<?php echo $data->nama_jabatan; ?>)</option>
													<?php endforeach; ?>
												</select>
											<?php } ?>

											<!--select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

										</div>
									</div>
								<?php } ?>

								<hr>

								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Judul E-Memo<span class="required"> *</span>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input id="subject_memo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="subject_memo" placeholder="Judul E-Memo" required="required" type="text" value="<?= !empty($memo->judul) ? $memo->judul : set_value('subject_memo') ?>">
										<span class="text-danger"></span>
									</div>
								</div>
								<div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Attachment</label>
									<?php if (!empty($memo->attach_name)) { ?>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input id="attch_exist" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="attch_exist" type="text" value="<?php echo $memo->attach_name; ?>" readonly>
											<input id="attch_exist_nm" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="attch_exist_nm" type="hidden" value="<?php echo $memo->attach; ?>">
											<input type="file" name="file[]" id="file" multiple>
										</div>
									<?php } else { ?>
										<input type="file" name="file[]" id="file" multiple>
									<?php } ?>
								</div>
							</div>

							<div class="item form-group">
								<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Isi E-Memo<span class="required"> *</span>
								</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<textarea class="ckeditor" name="ckeditor" id="ckeditor">
								<?php
								if ($this->uri->segment(3) == true) {
									$array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
									$bln = $array_bln[date('n', strtotime($memo->tanggal))];
								}
								if (!empty($memo->isi_memo)) {
									echo ('<br><hr/>');
									echo ('<br> created by. ');
									$nip = $memo->nip_dari;

									$query = $this->db->query("SELECT nama,nama_jabatan FROM users WHERE nip='$nip';")->row()->nama;
									echo $query;
									if ($this->uri->segment(3) == true) {
										echo "<br>";
										echo "No Memo : " . sprintf("%03d", $memo->nomor_memo) . '/E-MEMO/' . $memo->kode_nama . '/' . $bln . '/' . date('Y', strtotime($memo->tanggal));
									}
									echo $memo->isi_memo;
								}

								echo set_value('ckeditor');
								?>
								
							</textarea>
								</div>
							</div>

							<div class="form-group">
								<label style="text-align: left; font-size:12px;" for="informasi" class="control-label col-md-3 col-sm-3 col-xs-12">
									<font color="red">* Pastikan pembuatan memo sudah benar sebelum memo dikirim</font>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<button type="button" class="btn btn-warning" onclick="history.back()">Back</button>
									<button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Cancel
									</button>
									<button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
									</button>
									<!--<button type="submit" id="save_project" name="save_project" class="btn btn-success" onclick="return clicked();">Submit</button>-->
									<button id="submit-memo" type="button" class="btn btn-success">Send</button><br>
									<!--<input type="submit" value="Save Customer" class="btn btn-success"/><br><br><br>-->
									<?php //echo form_submit('save_customer', 'Save Customer', 'onclick="return clicked();", class="btn btn-success"'); 
									?>
								</div>
							</div>

							</form>
						</div>
						</br>
						</br>
						</br>
					</div>
				</div>
			</div>

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
			<?php if ($this->session->userdata('msg') == 'error2') { ?>
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Error Input!',
				})
			<?php
				$this->session->unset_userdata('msg');
			} else if ($this->session->userdata('msg_memo')) { ?>
				Swal.fire({
					icon: 'success',
					title: 'Success input',
					text: 'Create & Send Success to ID <?php echo $this->session->userdata('msg_memo') ?>',
				})
			<?php
				$this->session->unset_userdata('msg_memo');
			} ?>

			$("#submit-memo").on('click', function(e) {
				Swal.fire({
					title: 'Are you sure?',
					text: "You want to submit the form?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes'
				}).then((result) => {
					if (result.isConfirmed) {
						$("#form_input").submit();
					} else {
						e.preventDefault();
					}
				})
			});

			$("#form_input").on('submit', () => {
				$("#submit-memo").attr('disabled', true);
				$("#submit-memo").html('Sending...');
				Swal.fire({
					title: 'Sending...',
					timerProgressBar: true,
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading()
					},
				})
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