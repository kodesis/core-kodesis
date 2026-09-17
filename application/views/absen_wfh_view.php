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
	<link href="<?php echo base_url(); ?>src/build/css/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>src/build/css/owl.theme.default.min.css" rel="stylesheet">

	<script defer src="<?= base_url() ?>resources/assets/javascript/face_logics/face-api.min.js"></script>

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
			display: block;
			justify-content: center;
		}

		/*video*/
		.video-container {
			align-items: center;
			justify-content: center;
		}

		/* Wrapper supaya canvas overlay pas di atas video */
		.video-wrapper {
			position: relative;
			display: inline-block;
		}

		.video-wrapper canvas {
			position: absolute;
			top: 0;
			left: 0;
			pointer-events: none;
		}

		/* Styles for mobile devices */
		@media (max-width: 768px) {
			.video-container {
				margin-left: 20px;
			}
		}

		#video {
			border-radius: 10px;
			background: #000;
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
							</li>
							<?php include 'notif_tello.php' ?>

						</ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main" style="height:600px">
				<div class="container">
					<div class="main--content">
						<div id="messageDiv" class="messageDiv" style="display:none;"> </div>
						<h5 id="lokasi_sekarang"></h5>
						<div class="attendance-button">
							<button hidden id="startButton" class="add">Launch Facial Recognition</button>
							<button id="endButton" class="add" style="display:none">End Attendance Process</button>
							<button hidden id="endAttendance" class="add">END Attendance Taking</button>
						</div>

						<!-- PENTING untuk iOS: playsinline + muted + autoplay -->
						<div class="video-container" style="display:none">
							<div class="video-wrapper">
								<video id="video" class="video-class" width="320" height="240" autoplay muted playsinline webkit-playsinline></video>
								<canvas id="overlay" width="320" height="240"></canvas>
							</div>
						</div>

						<div class="table-container">
							<div id="studentTableContainer"></div>
						</div>
						<p id="location"></p>
					</div>
				</div>
				<!-- /page content -->
			</div>
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

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
					autoplay: true
				}
			}
		})
	</script>
	<script>
		// ============================================================
		// STATE GLOBAL
		// ============================================================
		let isWithinRange = false;
		let locationName = "";
		let students = [];
		let labels = [];
		let detectedFaces = [];
		let videoStream = null;
		let modelsLoaded = false;
		let faceMatcher = null;
		let detectionRunning = false;
		let attendanceDone = false; // cegah absensi terkirim berkali-kali

		const video = document.getElementById("video");
		const videoContainer = document.querySelector(".video-container");
		const overlay = document.getElementById("overlay");

		const locations = [
			<?php
			if ($lokasi_absensi) {
				foreach ($lokasi_absensi as $l) {
					if ($l['id'] == $lokasi_presensi_user->id_lokasi_presensi) { ?> {
							name: "<?= addslashes($l['nama_lokasi']) ?>",
							latitude: <?= $l['latitude'] ?>,
							longitude: <?= $l['longitude'] ?>,
							radius: <?= $l['radius'] ?> // Radius in kilometers
						},
				<?php }
				}
			} else { ?> {
					name: "Graha Dirgantara",
					latitude: -6.2559536,
					longitude: 106.8826187,
					radius: 0.5
				},
				{
					name: "Parkir Bandes",
					latitude: -6.2586284,
					longitude: 106.8820789,
					radius: 0.5
				},
				{
					name: "Mlejit",
					latitude: -6.2638584,
					longitude: 106.8856266,
					radius: 0.5
				}
			<?php } ?>
		];

		// ============================================================
		// HELPER LOADING (SweetAlert)
		// ============================================================
		function showLoading(title, text) {
			// Kalau loading sudah tampil, cukup ganti teksnya (tidak berkedip)
			if (Swal.isVisible() && Swal.isLoading()) {
				const t = Swal.getTitle();
				const h = Swal.getHtmlContainer();
				if (t) t.textContent = title;
				if (h) {
					h.textContent = text || '';
					h.style.display = 'block';
				}
				return;
			}
			Swal.fire({
				title: title,
				text: text || ' ',
				allowOutsideClick: false,
				allowEscapeKey: false,
				showConfirmButton: false,
				didOpen: () => Swal.showLoading()
			});
		}

		// face-api.min.js dimuat dengan "defer", pastikan sudah siap
		function waitForFaceApi(timeoutMs = 30000) {
			return new Promise((resolve, reject) => {
				const start = Date.now();
				(function check() {
					if (window.faceapi) return resolve();
					if (Date.now() - start > timeoutMs) return reject(new Error('Library face-api gagal dimuat. Periksa koneksi internet.'));
					setTimeout(check, 200);
				})();
			});
		}

		function postJSON(url, body, isJson) {
			return new Promise((resolve, reject) => {
				const xhr = new XMLHttpRequest();
				xhr.open("POST", url, true);
				xhr.setRequestHeader("Content-Type", isJson ? "application/json" : "application/x-www-form-urlencoded");
				xhr.timeout = 60000;
				xhr.onload = function() {
					if (xhr.status !== 200) return reject(new Error('Server error (HTTP ' + xhr.status + ')'));
					try {
						resolve(JSON.parse(xhr.responseText));
					} catch (e) {
						reject(new Error('Respon server tidak valid.'));
					}
				};
				xhr.onerror = () => reject(new Error('Koneksi ke server gagal.'));
				xhr.ontimeout = () => reject(new Error('Koneksi ke server timeout.'));
				xhr.send(body || null);
			});
		}

		// ============================================================
		// 1. LOKASI
		// ============================================================
		function getLocation() {
			if (!navigator.geolocation) {
				Swal.fire('Error', 'Geolocation tidak didukung oleh browser ini.', 'error');
				return;
			}
			showLoading('Memeriksa lokasi...', 'Mohon izinkan akses lokasi');
			navigator.geolocation.getCurrentPosition(showPosition, showError, {
				enableHighAccuracy: false,
				timeout: 15000, // iOS kadang menggantung tanpa timeout
				maximumAge: 60000
			});
		}

		function showPosition(position) {
			const userLatitude = position.coords.latitude;
			const userLongitude = position.coords.longitude;

			for (const location of locations) {
				if (isWithinRadius(userLatitude, userLongitude, location.latitude, location.longitude, location.radius)) {
					isWithinRange = true;
					locationName = location.name;
					break;
				}
			}

			if (isWithinRange) {
				$('#lokasi_sekarang').text('Lokasi Sekarang ' + locationName);
				startFaceAttendance();
			} else {
				$('#lokasi_sekarang').text('Lokasi Sekarang Di Luar Jangkauan');
				Swal.fire({
					title: 'You are not within range! Ingin Tetap Absen?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Ya, Absen',
					cancelButtonText: 'Tidak',
					reverseButtons: true
				}).then((result) => {
					if (result.isConfirmed) {
						startFaceAttendance();
					}
				});
			}
		}

		function showError(error) {
			switch (error.code) {
				case error.PERMISSION_DENIED:
					Swal.fire('Error', 'Izin akses lokasi ditolak. Aktifkan di Pengaturan > Privasi > Layanan Lokasi > Safari.', 'error');
					break;
				case error.POSITION_UNAVAILABLE:
					Swal.fire('Error', 'Informasi lokasi tidak tersedia.', 'error');
					break;
				case error.TIMEOUT:
					Swal.fire('Error', 'Permintaan lokasi timeout. Silakan coba lagi.', 'error');
					break;
				default:
					Swal.fire('Error', 'Terjadi kesalahan saat mengambil lokasi.', 'error');
					break;
			}
		}

		function isWithinRadius(lat1, lon1, lat2, lon2, radiusInKm) {
			const toRadians = (degrees) => degrees * (Math.PI / 180);
			const earthRadiusKm = 6371;
			const dLat = toRadians(lat2 - lat1);
			const dLon = toRadians(lon2 - lon1);
			const a =
				Math.sin(dLat / 2) * Math.sin(dLat / 2) +
				Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
				Math.sin(dLon / 2) * Math.sin(dLon / 2);
			const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			return earthRadiusKm * c <= radiusInKm;
		}

		// ============================================================
		// 2. ALUR UTAMA: data -> model -> foto -> kamera -> deteksi
		// ============================================================
		async function startFaceAttendance() {
			try {
				showLoading('Memuat data pengguna...', 'Langkah 1 dari 4');
				const response = await postJSON("fetch_user");

				if (response.status === "No Picture") {
					Swal.fire('Alert', 'Picture Not Found, Please take Picture first', 'warning');
					return;
				}
				if (response.status !== "success") {
					throw new Error(response.message || 'Gagal memuat data pengguna.');
				}

				students = response.data;
				labels = students.map(s => s.username);
				document.getElementById("studentTableContainer").innerHTML = response.html;

				showLoading('Memuat model pengenalan wajah...', 'Langkah 2 dari 4 (pertama kali bisa agak lama)');
				await loadModels();

				showLoading('Memproses foto wajah terdaftar...', 'Langkah 3 dari 4');
				const labeledDescriptors = await getLabeledFaceDescriptions();
				if (labeledDescriptors.length === 0) {
					Swal.fire('Alert', 'Wajah tidak terdeteksi pada foto terdaftar. Silakan ambil foto terlebih dahulu.', 'warning');
					return;
				}
				faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6);

				showLoading('Membuka kamera...', 'Langkah 4 dari 4');
				await startWebcam();

				Swal.fire({
					icon: 'info',
					title: 'Kamera siap',
					text: 'Hadapkan wajah Anda ke kamera',
					timer: 2000,
					showConfirmButton: false
				});

				startDetectionLoop();
			} catch (err) {
				console.error(err);
				stopWebcam();
				Swal.fire('Error', err.message || 'Terjadi kesalahan.', 'error');
			}
		}

		async function loadModels() {
			if (modelsLoaded) return;
			await waitForFaceApi();
			try {
				await Promise.all([
					faceapi.nets.ssdMobilenetv1.loadFromUri("../models"),
					faceapi.nets.faceRecognitionNet.loadFromUri("../models"),
					faceapi.nets.faceLandmark68Net.loadFromUri("../models"),
				]);
			} catch (e) {
				console.error(e);
				throw new Error('Model gagal dimuat, periksa lokasi folder models.');
			}
			modelsLoaded = true;
			console.log("models loaded successfully");
		}

		async function getLabeledFaceDescriptions() {
			const labeledDescriptors = [];
			const options = new faceapi.SsdMobilenetv1Options({
				minConfidence: 0.5
			});
			const TOTAL_FOTO = 5;

			for (const student of students) {
				const descriptions = [];

				// Unduh kelima foto secara paralel (lebih cepat daripada satu per satu)
				const imgs = await Promise.all(
					Array.from({
							length: TOTAL_FOTO
						}, (_, i) =>
						faceapi.fetchImage(`../resources/labels/${student.username}/${i + 1}.png`)
						.catch(err => {
							console.warn(`Gagal memuat ${student.username}/${i + 1}.png`, err);
							return null;
						})
					)
				);

				// Deteksi dilakukan berurutan (GPU iPhone tidak kuat paralel)
				for (let i = 0; i < imgs.length; i++) {
					if (!imgs[i]) continue;
					showLoading('Memproses foto wajah terdaftar...', `Langkah 3 dari 4 (foto ${i + 1}/${TOTAL_FOTO})`);
					try {
						const detection = await faceapi
							.detectSingleFace(imgs[i], options)
							.withFaceLandmarks()
							.withFaceDescriptor();
						if (detection) {
							descriptions.push(detection.descriptor);
						} else {
							console.log(`No face detected in ${student.username}/${i + 1}.png`);
						}
					} catch (error) {
						console.error(`Error processing ${student.username}/${i + 1}.png:`, error);
					}
				}

				if (descriptions.length > 0) {
					// Label = username (unik), nama ditampilkan saat menggambar kotak
					labeledDescriptors.push(new faceapi.LabeledFaceDescriptors(student.username, descriptions));
				}
			}
			return labeledDescriptors;
		}

		async function startWebcam() {
			if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
				throw new Error('Browser tidak mendukung kamera. Pastikan halaman dibuka melalui HTTPS.');
			}

			videoContainer.style.display = "flex";

			try {
				videoStream = await navigator.mediaDevices.getUserMedia({
					video: {
						facingMode: "user",
						width: {
							ideal: 640
						},
						height: {
							ideal: 480
						}
					},
					audio: false
				});
			} catch (error) {
				console.error("Error accessing webcam:", error);
				throw new Error('Akses kamera ditolak atau tidak tersedia. Aktifkan izin kamera untuk Safari.');
			}

			// Wajib untuk iOS Safari
			video.setAttribute('playsinline', '');
			video.setAttribute('webkit-playsinline', '');
			video.muted = true;
			video.srcObject = videoStream;

			// Tunggu metadata siap lalu play secara eksplisit
			await new Promise((resolve) => {
				if (video.readyState >= 1) return resolve();
				video.onloadedmetadata = () => resolve();
			});

			try {
				await video.play();
			} catch (e) {
				console.error(e);
				throw new Error('Video kamera tidak bisa diputar. Coba muat ulang halaman.');
			}
		}

		function startDetectionLoop() {
			if (detectionRunning) return;
			detectionRunning = true;

			const displaySize = {
				width: video.width,
				height: video.height
			};
			faceapi.matchDimensions(overlay, displaySize);
			const ctx = overlay.getContext("2d");
			const options = new faceapi.SsdMobilenetv1Options({
				minConfidence: 0.5
			});

			// Pakai setTimeout berantai, BUKAN setInterval, supaya deteksi tidak menumpuk
			const loop = async () => {
				if (!detectionRunning || attendanceDone) return;

				if (video.paused || video.ended || video.readyState < 2) {
					setTimeout(loop, 300);
					return;
				}

				try {
					const detections = await faceapi
						.detectAllFaces(video, options)
						.withFaceLandmarks()
						.withFaceDescriptors();

					if (!detectionRunning || attendanceDone) return;

					const resizedDetections = faceapi.resizeResults(detections, displaySize);
					ctx.clearRect(0, 0, overlay.width, overlay.height);

					const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

					results.forEach((result, i) => {
						const student = students.find(s => s.username === result.label);
						new faceapi.draw.DrawBox(resizedDetections[i].detection.box, {
							label: student ? student.nama : 'Tidak dikenal'
						}).draw(overlay);
					});

					detectedFaces = results.map(r => r.label).filter(l => l !== 'unknown');
					if (detectedFaces.length > 0) {
						markAttendance(detectedFaces);
					}
				} catch (e) {
					console.error('Detection error:', e);
				}

				if (detectionRunning && !attendanceDone) {
					setTimeout(loop, 300);
				}
			};

			loop();
		}

		// ============================================================
		// 3. TANDAI & KIRIM ABSENSI
		// ============================================================
		function markAttendance(detectedFaces) {
			if (attendanceDone) return;

			let matched = false;

			document.querySelectorAll("#studentTableContainer tr").forEach((row) => {
				if (matched || !row.cells[0]) return;
				const username = row.cells[0].innerText.trim();

				<?php
				date_default_timezone_set('Asia/Jakarta');
				$current_time = new DateTime();
				$jam_masuk_plus_two = (new DateTime($data_users->jam_masuk))->modify('+5 minutes');
				$jam_keluar_plus_two = (new DateTime($data_users->jam_keluar))->modify('+0 hours');
				?>
				if (detectedFaces.includes(username)) {
					matched = true;

					if (isWithinRange) {
						<?php if ($current_time <= $jam_masuk_plus_two || $current_time >= $jam_keluar_plus_two) { ?>
							row.cells[3].innerText = "Present";
							row.cells[4].innerText = locationName;
						<?php } else { ?>
							row.cells[3].innerText = "Pending";
							row.cells[4].innerText = locationName;
						<?php } ?>
					} else {
						row.cells[3].innerText = "Pending";
						row.cells[4].innerText = "Di Luar";
					}

					const currentDate = new Date();
					const indonesiaTimeOffset = 7;
					const indonesiaTime = new Date(currentDate.getTime() + indonesiaTimeOffset * 60 * 60 * 1000);
					const formattedDateTime = indonesiaTime.toISOString().replace("T", " ").split(".")[0];
					const formattedDateOnly = indonesiaTime.toISOString().split("T")[0];

					row.cells[5].innerText = formattedDateTime;
					row.cells[6].innerText = formattedDateOnly;
				}
			});

			if (!matched) return;

			// Kunci supaya tidak terkirim berulang
			attendanceDone = true;
			const capturedImage = captureImage(video);
			stopWebcam();
			videoContainer.style.display = "none";

			showLoading('Menyimpan absensi...', 'Mohon tunggu, jangan tutup halaman');

			sendAttendanceDataToServer(capturedImage)
				.then((response) => {
					Swal.fire('Success', response.message || 'Anda Berhasil Melakukan Absensi', 'success');
				})
				.catch((err) => {
					console.error(err);
					Swal.fire('Error', (err.message || 'Gagal menyimpan absensi.') + ' Silakan muat ulang halaman dan coba lagi.', 'error');
				});
		}

		function captureImage(video) {
			const canvas = document.createElement("canvas");
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
			canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
			return canvas.toDataURL("image/png");
		}

		function sendAttendanceDataToServer(capturedImage) {
			const attendanceData = [];

			document.querySelectorAll("#studentTableContainer tr").forEach((row, index) => {
				if (index === 0) return;
				attendanceData.push({
					username: row.cells[0].innerText.trim(),
					nip: row.cells[1].innerText.trim(),
					nama: row.cells[2].innerText.trim(),
					attendanceStatus: row.cells[3].innerText.trim(),
					lokasiAttendance: row.cells[4].innerText.trim(),
					tanggalAttendance: row.cells[5].innerText.trim(),
					capturedImage: capturedImage
				});
			});

			return postJSON("recordAttendance", JSON.stringify(attendanceData), true)
				.then((response) => {
					if (response.status === "success") return response;
					throw new Error(response.message || 'Terjadi kesalahan saat menyimpan absensi.');
				});
		}

		function showMessage(message) {
			const messageDiv = document.getElementById("messageDiv");
			messageDiv.style.display = "block";
			messageDiv.innerHTML = message;
			messageDiv.style.opacity = 1;
			setTimeout(() => {
				messageDiv.style.opacity = 0;
			}, 5000);
		}

		function stopWebcam() {
			detectionRunning = false;
			if (videoStream) {
				videoStream.getTracks().forEach(track => track.stop());
				videoStream = null;
			}
			video.srcObject = null;
			const ctx = overlay.getContext("2d");
			ctx.clearRect(0, 0, overlay.width, overlay.height);
		}

		// iOS tetap menyalakan kamera saat pindah halaman, matikan manual
		window.addEventListener("pagehide", stopWebcam);

		// ============================================================
		// 4. TABEL SAJA (SUDAH ABSEN)
		// ============================================================
		async function loadTableOnly(url) {
			try {
				showLoading('Memuat data absensi...', 'Mohon tunggu');
				const response = await postJSON(url);

				if (response.status === "success") {
					document.getElementById("studentTableContainer").innerHTML = response.html;
					videoContainer.style.display = "none"; // sebelumnya salah: style.display('none')
					students = response.data;
					labels = students.map(s => s.username);
					Swal.close();
				} else if (response.status === "No Picture") {
					Swal.fire('Alert', 'Picture Not Found, Please take Picture first', 'warning');
				} else {
					throw new Error(response.message || 'Gagal memuat data.');
				}
			} catch (err) {
				console.error(err);
				Swal.fire('Error', err.message, 'error');
			}
		}

		// Swal "sudah absen" ditampilkan setelah tabel selesai dimuat
		function updateTableMasuk() {
			loadTableOnly("fetch_user/masuk").then(() => {
				if (!Swal.isVisible()) Swal.fire('Alert', 'Anda Sudah Melakukan Absensi Masuk', 'warning');
			});
		}

		function updateTablePulang() {
			loadTableOnly("fetch_user/pulang").then(() => {
				if (!Swal.isVisible()) Swal.fire('Alert', 'Anda Sudah Melakukan Absensi Pulang', 'warning');
			});
		}

		function updateTableAbsensi() {
			loadTableOnly("fetch_user/absensi").then(() => {
				if (!Swal.isVisible()) Swal.fire('Alert', 'Anda Sudah Melakukan Absensi', 'warning');
			});
		}

		// Kompatibilitas dengan kode lama
		function updateTable() {
			startFaceAttendance();
		}

		document.getElementById("endAttendance").addEventListener("click", function() {
			stopWebcam();
			videoContainer.style.display = "none";
			sendAttendanceDataToServer();
		});

		// ============================================================
		// 5. INISIALISASI
		// ============================================================
		<?php
		if (empty($data_users)) {
		?>
			getLocation();
		<?php
		} else {
			date_default_timezone_set('Asia/Jakarta');
			$current_time = new DateTime();
			$jam_masuk_plus_two = (new DateTime($data_users->jam_masuk))->modify('+5 minutes');
			$jam_keluar_plus_two = (new DateTime($data_users->jam_keluar))->modify('+0 hours');
		?>
			<?php if ($current_time <= $jam_masuk_plus_two) { ?>
				<?php if (empty($result1)) { ?>
					getLocation();
				<?php } else { ?>
					updateTableMasuk();
				<?php } ?>
			<?php } else if ($current_time >= $jam_keluar_plus_two) { ?>
				<?php if (empty($result2)) { ?>
					getLocation();
				<?php } else { ?>
					updateTablePulang();
				<?php } ?>
			<?php } else { ?>
				<?php if (empty($result1) && empty($result3)) { ?>
					getLocation();
				<?php } else { ?>
					updateTableAbsensi();
				<?php } ?>
			<?php } ?>
		<?php } ?>

		// Format dengan "T" agar valid di Safari iOS
		const currentTime = new Date("<?php echo $current_time->format('Y-m-d\TH:i:s'); ?>");
		console.log('Current time:', currentTime);
	</script>
	<script src='<?= base_url() ?>resources/assets/javascript/active_link.js'></script>
</body>

</html>