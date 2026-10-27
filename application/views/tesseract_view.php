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
	<title>Kodesis | Bussines Development</title>
	<!-- Bootstrap -->
	<link href="<?php echo base_url(); ?>src/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link href="<?php echo base_url(); ?>login_lib/vendor/bootstrap/css/bootstrap-grid.css" rel="stylesheet"> -->
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
	<link href="<?php echo base_url(); ?>src/build/css/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>src/build/css/owl.theme.default.min.css" rel="stylesheet">

	<!-- <link rel="stylesheet" href="<?= base_url() ?>resources/assets/css/styles.css"> -->

	<link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" rel="stylesheet">
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


		.justify-content-center {
			display: flex;
			justify-content: center;
		}


		/*video*/
		canvas {
			position: absolute;

		}

		.video-container {
			display: flex;
			align-items: center;
			justify-content: center;
		}

		#video {
			border-radius: 10px;
			box-shadow: #000;
		}

		/* Tesseract OCR */
		.ocr-dropzone {
			position: relative;
			border: 2px dashed #b0bec5;
			border-radius: 6px;
			padding: 20px;
			text-align: center;
			color: #73879C;
			margin-bottom: 15px;
			cursor: pointer;
			min-height: 160px;
			transition: border-color .2s, background .2s;
		}

		.ocr-dropzone.dragover {
			border-color: #26B99A;
			background: #f3fbf9;
		}

		.ocr-dropzone input[type=file] {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			opacity: 0;
			cursor: pointer;
		}

		.ocr-preview {
			max-width: 100%;
			max-height: 260px;
			border-radius: 4px;
		}

		.ocr-result {
			font-family: Consolas, Monaco, monospace;
			font-size: 13px;
			resize: vertical;
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
						<a href="<?php echo base_url(); ?>" class="site_title">
							<img src="<?= $this->session->userdata('icon') ?>" alt="..." width="60">
							<span><?= $this->session->userdata('nama_singkat') ?></span>
						</a>
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
								<!--a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false"-->
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
				<div class="container">
					<div class="main--content ocr-page">
						<div class="page-title">
							<div class="title_left">
								<h3>Tesseract OCR <small>Ekstrak teks dari gambar</small></h3>
							</div>
						</div>
						<div class="clearfix"></div>

						<?php if (!$server_ready) { ?>
							<div class="alert alert-warning">
								<i class="fa fa-info-circle"></i>
								Binary <b>tesseract</b> belum terpasang di server. OCR akan diproses langsung di browser (Tesseract.js).
							</div>
						<?php } ?>

						<div class="row">
							<!-- form upload -->
							<div class="col-md-5 col-sm-12">
								<div class="x_panel">
									<div class="x_title">
										<h2><i class="fa fa-upload"></i> Upload Gambar</h2>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<form id="form_tesseract" method="post" enctype="multipart/form-data">
											<div id="drop_zone" class="ocr-dropzone">
												<input type="file" name="image" id="image" accept="image/*" required>
												<div id="drop_hint">
													<i class="fa fa-file-image-o fa-3x"></i>
													<p>Klik atau seret gambar ke sini<br><small>JPG, PNG, BMP, GIF, TIFF, WEBP &middot; maks 5 MB</small></p>
												</div>
												<img id="preview" class="ocr-preview" alt="preview" style="display:none;">
											</div>

											<div class="form-group">
												<label for="lang">Bahasa</label>
												<select class="form-control" name="lang" id="lang">
													<?php foreach ($languages as $code => $label) { ?>
														<option value="<?= $code ?>" <?= $code == 'ind+eng' ? 'selected' : '' ?>><?= $label ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
												<label for="psm">Mode Halaman</label>
												<select class="form-control" name="psm" id="psm">
													<?php foreach ($psm_modes as $code => $label) { ?>
														<option value="<?= $code ?>"><?= $label ?></option>
													<?php } ?>
												</select>
											</div>

											<div class="progress" id="ocr_progress" style="display:none;">
												<div class="progress-bar progress-bar-striped active" role="progressbar" style="width:100%;">Memproses...</div>
											</div>

											<button type="submit" class="btn btn-primary btn-block" id="btn_submit">
												<i class="fa fa-magic"></i> Proses OCR
											</button>
										</form>
									</div>
								</div>
							</div>

							<!-- hasil -->
							<div class="col-md-7 col-sm-12">
								<div class="x_panel">
									<div class="x_title">
										<h2><i class="fa fa-file-text-o"></i> Hasil Teks</h2>
										<div class="pull-right" id="result_meta"></div>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<textarea id="result_text" class="form-control ocr-result" rows="16" placeholder="Hasil OCR akan tampil di sini..."></textarea>
										<div style="margin-top:10px;">
											<button type="button" class="btn btn-default btn-sm" id="btn_copy"><i class="fa fa-copy"></i> Salin</button>
											<a href="#" class="btn btn-default btn-sm disabled" id="btn_download"><i class="fa fa-download"></i> Download .txt</a>
											<button type="button" class="btn btn-default btn-sm" id="btn_clear"><i class="fa fa-eraser"></i> Bersihkan</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- riwayat -->
						<div class="row">
							<div class="col-md-12">
								<div class="x_panel">
									<div class="x_title">
										<h2><i class="fa fa-history"></i> Riwayat OCR</h2>
										<div class="clearfix"></div>
									</div>
									<div class="x_content table-responsive">
										<table class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>Tanggal</th>
													<th>File</th>
													<th>Bahasa</th>
													<th>Engine</th>
													<th>Cuplikan</th>
													<th style="width:150px;">Aksi</th>
												</tr>
											</thead>
											<tbody id="history_body"></tbody>
										</table>
									</div>
								</div>
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
		<script src="<?php echo base_url(); ?>src/build/js/owl.carousel.min.js"></script>

		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<script>
			$('.owl-carousel').owlCarousel({
				loop: true,
				margin: 10,
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
						nav: true
					},
					600: {
						items: 3,
						nav: false
					},
					1000: {
						items: 1,
						nav: true,
						loop: true,
						autoplay: true,
					}
				}
			})
		</script>

		<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.1.1/dist/tesseract.min.js"></script>
		<script>
			(function() {
				var BASE = '<?= base_url('tesseract') ?>';
				var historyRows = <?= json_encode($history) ?>;
				var currentId = null;

				function esc(str) {
					return $('<div>').text(str == null ? '' : str).html();
				}

				function setLoading(on, label) {
					$('#btn_submit').prop('disabled', on);
					$('#ocr_progress').toggle(on);
					$('#ocr_progress .progress-bar').css('width', '100%').text(label || 'Memproses...');
				}

				function setProgress(pct, label) {
					$('#ocr_progress .progress-bar').css('width', pct + '%').text(label + ' ' + pct + '%');
				}

				function showResult(id, text, meta) {
					currentId = id;
					$('#result_text').val(text);
					$('#result_meta').html(meta || '');
					$('#btn_download').toggleClass('disabled', !id).attr('href', id ? BASE + '/download/' + id : '#');
				}

				function renderHistory() {
					var $body = $('#history_body').empty();
					if (!historyRows.length) {
						$body.append('<tr><td colspan="6" class="text-center">Belum ada riwayat.</td></tr>');
						return;
					}
					$.each(historyRows, function(i, row) {
						$body.append(
							'<tr>' +
							'<td>' + esc(row.created_at) + '</td>' +
							'<td>' + esc(row.original_name || row.file_name) + '</td>' +
							'<td>' + esc(row.lang) + '</td>' +
							'<td><span class="label label-' + (row.engine == 'server' ? 'primary' : 'info') + '">' + esc(row.engine) + '</span></td>' +
							'<td><small>' + esc(row.preview) + '</small></td>' +
							'<td>' +
							'<button class="btn btn-xs btn-info btn-view" data-id="' + row.id + '"><i class="fa fa-eye"></i></button> ' +
							'<a class="btn btn-xs btn-default" href="' + BASE + '/download/' + row.id + '"><i class="fa fa-download"></i></a> ' +
							'<button class="btn btn-xs btn-danger btn-delete" data-id="' + row.id + '"><i class="fa fa-trash"></i></button>' +
							'</td>' +
							'</tr>'
						);
					});
				}

				function reloadHistory() {
					$.getJSON(BASE + '/history', function(res) {
						if (res.status) {
							historyRows = res.data;
							renderHistory();
						}
					});
				}

				function metaLabel(engine, duration, confidence) {
					var html = '<span class="label label-' + (engine == 'server' ? 'primary' : 'info') + '">' + engine + '</span>';
					if (duration) html += ' <small>' + duration + ' detik</small>';
					if (confidence) html += ' <small>&middot; akurasi ' + Math.round(confidence) + '%</small>';
					return html;
				}

				// fallback: OCR di browser dengan Tesseract.js
				async function processInBrowser(file, uploadedName) {
					var lang = $('#lang').val();
					var psm = $('#psm').val();
					var start = performance.now();

					var worker = await Tesseract.createWorker(lang.split('+'), 1, {
						logger: function(m) {
							if (m.status === 'recognizing text') {
								setProgress(Math.round(m.progress * 100), 'Membaca teks');
							} else if (m.progress !== undefined) {
								setProgress(Math.round(m.progress * 100), 'Memuat engine');
							}
						}
					});
					await worker.setParameters({
						tessedit_pageseg_mode: String(psm)
					});
					var result = await worker.recognize(file);
					await worker.terminate();

					var text = result.data.text;
					var confidence = result.data.confidence;
					var duration = ((performance.now() - start) / 1000).toFixed(2);

					var res = await $.post(BASE + '/save_client_result', {
						file_name: uploadedName,
						original_name: file.name,
						lang: lang,
						psm: psm,
						text: text,
						confidence: confidence,
						duration: duration
					});

					showResult(res.status ? res.id : null, text, metaLabel('browser', duration, confidence));
					reloadHistory();
				}

				// preview + drag & drop
				$('#image').on('change', function() {
					var file = this.files[0];
					if (!file) return;
					var reader = new FileReader();
					reader.onload = function(e) {
						$('#preview').attr('src', e.target.result).show();
						$('#drop_hint').hide();
					};
					reader.readAsDataURL(file);
				});
				$('#drop_zone').on('dragover dragenter', function() {
					$(this).addClass('dragover');
				}).on('dragleave drop', function() {
					$(this).removeClass('dragover');
				});

				$('#form_tesseract').on('submit', function(e) {
					e.preventDefault();
					var file = $('#image')[0].files[0];
					if (!file) {
						Swal.fire('Oops', 'Pilih gambar terlebih dahulu.', 'warning');
						return;
					}

					setLoading(true, 'Mengupload & memproses...');
					$.ajax({
						url: BASE + '/process',
						type: 'POST',
						data: new FormData(this),
						processData: false,
						contentType: false,
						dataType: 'json'
					}).done(function(res) {
						if (res.status) {
							showResult(res.id, res.text, metaLabel(res.engine, res.duration));
							reloadHistory();
							if (!$.trim(res.text)) Swal.fire('Info', res.message, 'info');
							setLoading(false);
						} else if (res.code === 'engine_not_found') {
							processInBrowser(file, res.file_name)
								.catch(function(err) {
									Swal.fire('Gagal', 'OCR di browser gagal: ' + err, 'error');
								})
								.finally(function() {
									setLoading(false);
								});
						} else {
							Swal.fire('Gagal', res.message, 'error');
							setLoading(false);
						}
					}).fail(function(xhr) {
						var msg = (xhr.responseJSON && xhr.responseJSON.message) || 'Terjadi kesalahan pada server.';
						Swal.fire('Gagal', msg, 'error');
						setLoading(false);
					});
				});

				$('#btn_copy').on('click', function() {
					var text = $('#result_text').val();
					if (!text) return;
					navigator.clipboard.writeText(text).then(function() {
						Swal.fire({
							icon: 'success',
							title: 'Teks disalin',
							timer: 1200,
							showConfirmButton: false
						});
					});
				});

				$('#btn_clear').on('click', function() {
					showResult(null, '', '');
					$('#form_tesseract')[0].reset();
					$('#preview').hide();
					$('#drop_hint').show();
				});

				$('#history_body').on('click', '.btn-view', function() {
					$.getJSON(BASE + '/detail/' + $(this).data('id'), function(res) {
						if (!res.status) return Swal.fire('Gagal', res.message, 'error');
						var d = res.data;
						showResult(d.id, d.result_text, metaLabel(d.engine, d.duration, d.confidence));
						$('#preview').attr('src', d.image_url).show();
						$('#drop_hint').hide();
						$('html, body').animate({
							scrollTop: $('.ocr-page').offset().top
						}, 300);
					});
				});

				$('#history_body').on('click', '.btn-delete', function() {
					var id = $(this).data('id');
					Swal.fire({
						title: 'Hapus riwayat ini?',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Hapus',
						cancelButtonText: 'Batal'
					}).then(function(r) {
						if (!r.isConfirmed) return;
						$.post(BASE + '/delete/' + id, function(res) {
							if (res.status && currentId == id) showResult(null, '', '');
							reloadHistory();
						}, 'json');
					});
				});

				renderHistory();
			})();
		</script>

		<script src='<?= base_url() ?>resources/assets/javascript/active_link.js'></script>
		<!-- <script src='<?= base_url() ?>resources/assets/javascript/face_logics/script.js'></script> -->
</body>

</html>