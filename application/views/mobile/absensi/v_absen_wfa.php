<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.css">
<style>
    #btn-create {
        position: fixed;
        bottom: 12%;
        right: 10px;
        z-index: 99;
        font-size: 18px;
        border: none;
        outline: none;
        background-color: #4A89DC;
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 4px;
    }

    #btn-create:hover {
        background-color: #555;
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

    #video {
        border-radius: 10px;
        background: #000;
    }

    #status_deteksi {
        text-align: center;
        margin-top: 8px;
        font-size: 13px;
    }
</style>
<div id="page">
    <?php include APPPATH . 'views/mobile/v_nav.php' ?>
    <div class="page-content">
        <div class="content mt-0 mb-3">
            <h3 class="text-center my-3">ABSEN WFA</h3>
        </div>
        <div class="card card-style">
            <div class="content" style="cursor: pointer;">
                <div class="main--content">
                    <div id="messageDiv" class="messageDiv" style="display:none;"> </div>
                    <h5 id="lokasi_sekarang"></h5>
                    <div class="attendance-button">
                        <button hidden id="startButton" class="add">Launch Facial Recognition</button>
                        <button id="endButton" class="add" style="display:none">End Attendance Process</button>
                        <button hidden id="endAttendance" class="add">END Attendance Taking</button>
                    </div>

                    <!-- PENTING untuk iOS: autoplay + muted + playsinline -->
                    <div id="konten_video" class="video-container" style="display:none">
                        <div class="video-wrapper">
                            <video id="video" class="video-class" width="320" height="240" autoplay muted playsinline webkit-playsinline></video>
                            <canvas id="overlay" width="320" height="240"></canvas>
                        </div>
                    </div>
                    <p id="status_deteksi"></p>

                    <div class="table-container">
                        <input type="hidden" name="latitude" id="latitude_studentTable">
                        <input type="hidden" name="longitude" id="longitude_studentTable">
                        <input type="hidden" name="nama_lokasi" id="nama_lokasi">
                        <input type="hidden" name="alamat_lokasi" id="alamat_lokasi">
                        <input type="hidden" name="jam_absen" id="jam_absen">
                        <input type="hidden" name="tipe_absensi" id="tipe_absensi">
                        <div id="studentTableContainer"></div>
                    </div>
                    <p id="location"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>resources/assets/javascript/face_logics/face-api.min.js"></script>

<script src="<?= base_url() ?>assets/vendor/sweetalert2/js/sweetalert2.all.min.js"></script>

<script>
    // ============================================================
    // STATE & KONFIGURASI
    // ============================================================
    let isWithinRange = false;
    let locationName = null;
    let AttendanceStatus = 'Absent';
    let students = [];
    let labels = [];
    let detectedFaces = [];
    let videoStream = null;
    let modelsLoaded = false;
    let faceMatcher = null;
    let detectionRunning = false;
    let attendanceDone = false; // cegah absensi terkirim berkali-kali
    let isProcessing = false; // cegah proses dobel

    const videoEl = document.getElementById("video");
    const videoContainerEl = document.getElementById("konten_video");
    const overlayEl = document.getElementById("overlay");
    const statusDeteksiEl = document.getElementById("status_deteksi");

    const MODEL_URL = "https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model";
    const BASE_IMAGE_PATH = "<?= base_url('resources/labels/') ?>";
    const RECORD_URL = "<?= base_url('mobile/absensi/recordAttendance') ?>";

    const SHIFT_AKTIF = {
        shift1: <?= json_encode((bool)$shift1) ?>,
        shift2: <?= json_encode((bool)$shift2) ?>,
        shift3: <?= json_encode((bool)$shift3) ?>
    };

    // json_encode supaya nama dengan tanda kutip tidak merusak JS
    const NAMA_JAM = {
        reguler: <?= json_encode($namareguler ?? 'Reguler') ?>,
        shift1: <?= json_encode($namashift1 ?? '') ?>,
        shift2: <?= json_encode($namashift2 ?? '') ?>,
        shift3: <?= json_encode($namashift3 ?? '') ?>
    };

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
    // HELPER
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

    function setStatus(text) {
        if (statusDeteksiEl) statusDeteksiEl.textContent = text || '';
    }

    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.innerText = value;
    }

    // Resolve null kalau respon kosong (recordAttendance tidak echo apa pun saat sudah absen)
    function postJSON(url, body, isJson) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", isJson ? "application/json" : "application/x-www-form-urlencoded");
            xhr.timeout = 60000;
            xhr.onload = function() {
                if (xhr.status !== 200) return reject(new Error('Server error (HTTP ' + xhr.status + ')'));
                const text = (xhr.responseText || '').trim();
                if (text === '') return resolve(null);
                try {
                    resolve(JSON.parse(text));
                } catch (e) {
                    console.error('Respon mentah:', text);
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
            startProcess(position);
        } else {
            $('#lokasi_sekarang').text('Lokasi Sekarang Di Luar Jangkauan');
            Swal.fire({
                title: 'Anda tidak berada dalam jangkauan! Ingin Tetap Absen?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Absen',
                cancelButtonText: 'Tidak',
                reverseButtons: true,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    startProcess(position);
                }
            });
        }
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                Swal.fire('Error', 'Izin akses lokasi ditolak. Aktifkan di Pengaturan > Privasi > Layanan Lokasi.', 'error');
                break;
            case error.POSITION_UNAVAILABLE:
                Swal.fire('Error', 'Informasi lokasi tidak tersedia.', 'error');
                break;
            case error.TIMEOUT:
                Swal.fire('Error', 'Permintaan lokasi timeout. Silakan coba lagi.', 'error');
                break;
            default:
                Swal.fire('Error', 'Terjadi kesalahan yang tidak diketahui.', 'error');
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

    // Tidak menghalangi proses utama, dengan batas waktu 8 detik
    function reverseGeocode(lat, lon) {
        const controller = window.AbortController ? new AbortController() : null;
        if (controller) setTimeout(() => controller.abort(), 8000);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`, controller ? {
                signal: controller.signal
            } : {})
            .then(response => response.json())
            .then(data => {
                document.getElementById('nama_lokasi').value = (data.address && data.address.road) || "Unknown Location";
                document.getElementById('alamat_lokasi').value = data.display_name || "Unknown Address";
            })
            .catch(error => console.warn("Gagal mengambil alamat:", error));
    }

    // ============================================================
    // 2. ALUR UTAMA
    // ============================================================
    async function startProcess(position) {
        if (isProcessing) return;
        isProcessing = true;

        try {
            const userLatitude = position.coords.latitude;
            const userLongitude = position.coords.longitude;
            $('#latitude_studentTable').val(userLatitude);
            $('#longitude_studentTable').val(userLongitude);
            reverseGeocode(userLatitude, userLongitude);

            // --- Data user ---
            showLoading('Memuat data pengguna...', 'Mohon tunggu');
            const response = await postJSON("fetch_user");

            if (!response) throw new Error('Respon server kosong.');
            if (response.status === "No Picture") {
                Swal.fire('Alert', 'Foto wajah belum ada, silakan ambil foto terlebih dahulu.', 'warning');
                return;
            }
            if (response.status !== "success") {
                throw new Error(response.message || 'Gagal memuat data pengguna.');
            }

            students = response.data;
            labels = students.map(s => s.username);
            document.getElementById("studentTableContainer").innerHTML = response.html;

            // --- Pilih shift (sebelum proses berat) ---
            const pilihan = await pilihShift();
            if (!pilihan) return; // dibatalkan
            $('#jam_absen').val(pilihan.jamAbsen);
            $('#tipe_absensi').val(pilihan.tipe);

            // --- Model ---
            showLoading('Memuat model pengenalan wajah...', 'Langkah 1 dari 3 (pertama kali bisa agak lama)');
            await loadModels();

            // --- Foto wajah terdaftar ---
            showLoading('Memproses foto wajah terdaftar...', 'Langkah 2 dari 3');
            const labeledDescriptors = await getLabeledFaceDescriptions();
            if (labeledDescriptors.length === 0) {
                Swal.fire('Alert', 'Wajah tidak terdeteksi pada foto terdaftar. Silakan ambil ulang foto wajah.', 'warning');
                return;
            }
            faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6);

            // --- Kamera ---
            showLoading('Membuka kamera...', 'Langkah 3 dari 3');
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
            videoContainerEl.style.display = "none";
            Swal.fire('Error', err.message || 'Terjadi kesalahan.', 'error');
        } finally {
            isProcessing = false;
        }
    }

    // Mengembalikan { jamAbsen, tipe } atau null jika dibatalkan
    async function pilihShift() {
        const styles = {
            reguler: 'background-color: #004e81; color: white;',
            shift1: 'background-color: #007da6; color: white;',
            shift2: 'background-color: #38a0b7; color: white;',
            shift3: 'background-color: #51baba; color: white;'
        };

        const activeShifts = ['reguler'];
        if (SHIFT_AKTIF.shift1) activeShifts.push('shift1');
        if (SHIFT_AKTIF.shift2) activeShifts.push('shift2');
        if (SHIFT_AKTIF.shift3) activeShifts.push('shift3');

        if (activeShifts.length <= 1) {
            return {
                jamAbsen: 'reguler',
                tipe: ''
            };
        }

        const escapeHtml = (s) => String(s).replace(/[&<>"']/g, c => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        } [c]));

        let buttonsHtml = '<p>Silakan pilih shift untuk absensi hari ini:</p>' +
            '<div style="display:flex; flex-direction:column; gap:12px; margin-top:15px;">';
        activeShifts.forEach(key => {
            buttonsHtml += `<button type="button" class="swal2-styled custom-shift-button" data-shift="${key}"
                style="${styles[key]} font-weight:600; padding:12px 20px; border-radius:8px; margin:0;">
                Pilih Jam ${escapeHtml(NAMA_JAM[key] || key)}
            </button>`;
        });
        buttonsHtml += `<button type="button" id="cancel-shift-selection" class="swal2-styled"
                style="background-color:#6c757d; color:white; margin:10px 0 0; padding:12px 20px; border-radius:8px;">
                Batal Absen
            </button></div>`;

        // Simpan pilihan di variabel, tidak bergantung pada versi Swal.close(value)
        let selectedShift = null;

        await Swal.fire({
            title: 'Pilih Jam Shift',
            icon: 'question',
            html: buttonsHtml,
            showConfirmButton: false,
            showCancelButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                document.querySelectorAll('.custom-shift-button').forEach(button => {
                    button.addEventListener('click', (e) => {
                        selectedShift = e.currentTarget.getAttribute('data-shift');
                        Swal.close();
                    });
                });
                document.getElementById('cancel-shift-selection').addEventListener('click', () => {
                    selectedShift = null;
                    Swal.close();
                });
            }
        });

        if (!selectedShift) {
            Swal.fire('Absensi Dibatalkan', 'Anda membatalkan proses pemilihan Shift.', 'error');
            return null;
        }

        if (selectedShift === 'reguler') {
            return {
                jamAbsen: 'reguler',
                tipe: ''
            };
        }

        const tipeResult = await Swal.fire({
            title: 'Pilih Tipe Absensi',
            text: 'Anda akan melakukan absensi apa?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Masuk',
            cancelButtonText: 'Pulang',
            confirmButtonColor: '#004e81',
            cancelButtonColor: '#007da6',
            allowOutsideClick: false, // supaya tidak tertutup tanpa memilih
            allowEscapeKey: false
        });

        return {
            jamAbsen: selectedShift,
            tipe: tipeResult.isConfirmed ? 'Masuk' : 'Pulang'
        };
    }

    async function loadModels() {
        if (modelsLoaded) return;
        if (!window.faceapi) {
            throw new Error('Library face-api gagal dimuat. Periksa koneksi internet.');
        }
        try {
            await Promise.all([
                faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URL),
                faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
                faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL)
            ]);
        } catch (e) {
            console.error(e);
            throw new Error('Model pengenalan wajah gagal dimuat. Periksa koneksi internet.');
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

            // Unduh 5 foto secara paralel
            const imgs = await Promise.all(
                Array.from({
                        length: TOTAL_FOTO
                    }, (_, i) =>
                    faceapi.fetchImage(`${BASE_IMAGE_PATH}${student.username}/${i + 1}.png`)
                    .catch(err => {
                        console.warn(`Gagal memuat ${student.username}/${i + 1}.png`, err);
                        return null;
                    })
                )
            );

            // Deteksi berurutan (GPU iPhone tidak kuat paralel)
            for (let i = 0; i < imgs.length; i++) {
                if (!imgs[i]) continue;
                showLoading('Memproses foto wajah terdaftar...', `Langkah 2 dari 3 (foto ${i + 1}/${TOTAL_FOTO})`);
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
                // Label = username (unik); nama ditampilkan saat menggambar kotak
                labeledDescriptors.push(new faceapi.LabeledFaceDescriptors(student.username, descriptions));
            }
        }
        return labeledDescriptors;
    }

    async function startWebcam() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            throw new Error('Browser tidak mendukung kamera. Pastikan halaman dibuka melalui HTTPS.');
        }

        videoContainerEl.style.display = "flex";

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
            throw new Error('Akses kamera ditolak atau tidak tersedia. Aktifkan izin kamera di pengaturan browser.');
        }

        // Wajib untuk iOS Safari
        videoEl.setAttribute('playsinline', '');
        videoEl.setAttribute('webkit-playsinline', '');
        videoEl.muted = true;
        videoEl.srcObject = videoStream;

        await new Promise((resolve) => {
            if (videoEl.readyState >= 1) return resolve();
            videoEl.onloadedmetadata = () => resolve();
        });

        try {
            await videoEl.play(); // play eksplisit, jangan andalkan autoplay
        } catch (e) {
            console.error(e);
            throw new Error('Video kamera tidak bisa diputar. Coba muat ulang halaman.');
        }
    }

    function startDetectionLoop() {
        if (detectionRunning) return;
        detectionRunning = true;

        const displaySize = {
            width: videoEl.width,
            height: videoEl.height
        };
        faceapi.matchDimensions(overlayEl, displaySize);
        const ctx = overlayEl.getContext("2d");
        const options = new faceapi.SsdMobilenetv1Options({
            minConfidence: 0.5
        });
        const startedAt = Date.now();

        setStatus('Mendeteksi wajah...');

        // setTimeout berantai, BUKAN setInterval, supaya deteksi tidak menumpuk
        const loop = async () => {
            if (!detectionRunning || attendanceDone) return;

            if (videoEl.paused || videoEl.ended || videoEl.readyState < 2) {
                setTimeout(loop, 300);
                return;
            }

            try {
                const detections = await faceapi
                    .detectAllFaces(videoEl, options)
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                if (!detectionRunning || attendanceDone) return;

                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                ctx.clearRect(0, 0, overlayEl.width, overlayEl.height);

                const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

                results.forEach((result, i) => {
                    const student = students.find(s => s.username === result.label);
                    new faceapi.draw.DrawBox(resizedDetections[i].detection.box, {
                        label: student ? student.nama : 'Tidak dikenal'
                    }).draw(overlayEl);
                });

                detectedFaces = results.map(r => r.label).filter(l => l !== 'unknown');

                if (detectedFaces.length > 0) {
                    markAttendance(detectedFaces);
                } else if (detections.length === 0) {
                    setStatus('Wajah belum terlihat, posisikan wajah di tengah kamera.');
                } else {
                    setStatus(Date.now() - startedAt > 20000 ?
                        'Wajah belum dikenali. Pastikan pencahayaan cukup dan wajah tidak tertutup.' :
                        'Mencocokkan wajah...');
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
    function markAttendance(faces) {
        if (attendanceDone) return;

        const usernameEl = document.getElementById('username');
        if (!usernameEl) return;
        const username = usernameEl.innerText.trim();
        if (!faces.includes(username)) return;

        // Kunci supaya tidak terkirim berulang
        attendanceDone = true;

        if (isWithinRange) {
            setText('absent', "Present");
            setText('lokasi', locationName);
            AttendanceStatus = "Present";
        } else {
            setText('absent', "Pending");
            setText('lokasi', "Di Luar");
            locationName = "Di Luar";
            AttendanceStatus = "Present";
        }

        const currentDate = new Date();
        const indonesiaTimeOffset = 7;
        const indonesiaTime = new Date(currentDate.getTime() + indonesiaTimeOffset * 60 * 60 * 1000);
        setText('tanggal', indonesiaTime.toISOString().replace("T", " ").split(".")[0]);
        setText('tanggalonly', indonesiaTime.toISOString().split("T")[0]);

        const capturedImage = captureImage(videoEl);
        stopWebcam();
        videoContainerEl.style.display = "none";
        setStatus('');

        showLoading('Menyimpan absensi...', 'Mohon tunggu, jangan tutup halaman');

        sendAttendanceDataToServer(capturedImage)
            .then((response) => {
                if (response.duplicate) {
                    Swal.fire('Info', response.message, 'warning');
                } else {
                    Swal.fire('Success', response.message || 'Anda Berhasil Melakukan Absensi', 'success');
                }
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
        const getText = (id) => {
            const el = document.getElementById(id);
            return el ? el.innerText.trim() : '';
        };

        const attendanceData = {
            username: getText('username'),
            nip: getText('nip'),
            nama: getText('nama'),
            attendanceStatus: AttendanceStatus,
            lokasiAttendance: locationName,
            tanggalAttendance: getText('tanggalonly'),
            capturedImage: capturedImage,
            latitude: $('#latitude_studentTable').val(),
            longitude: $('#longitude_studentTable').val(),
            jam_absen: $('#jam_absen').val(),
            tipe_absensi: $('#tipe_absensi').val(),
        };

        return postJSON(RECORD_URL, JSON.stringify(attendanceData), true)
            .then((response) => {
                // Controller tidak mengirim apa pun jika absensi tipe ini sudah ada
                if (!response) {
                    return {
                        duplicate: true,
                        message: 'Anda sudah melakukan absensi ' + ($('#tipe_absensi').val() || '') + ' hari ini.'
                    };
                }
                if (response.status == "success") return response;
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
        videoEl.srcObject = null;
        overlayEl.getContext("2d").clearRect(0, 0, overlayEl.width, overlayEl.height);
    }

    // iOS tetap menyalakan kamera saat pindah halaman, matikan manual
    window.addEventListener("pagehide", stopWebcam);

    // ============================================================
    // 4. TABEL SAJA (SUDAH ABSEN)
    // ============================================================
    async function loadTableOnly(url, alertMessage) {
        try {
            showLoading('Memuat data absensi...', 'Mohon tunggu');
            const response = await postJSON(url);

            if (response && response.status === "success") {
                document.getElementById("studentTableContainer").innerHTML = response.html;
                videoContainerEl.style.display = 'none';
                students = response.data;
                labels = students.map(s => s.username);
                Swal.fire('Alert', alertMessage, 'warning');
            } else if (response && response.status === "No Picture") {
                Swal.fire('Alert', 'Foto wajah belum ada, silakan ambil foto terlebih dahulu.', 'warning');
            } else {
                throw new Error((response && response.message) || 'Gagal memuat data absensi.');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', err.message, 'error');
        }
    }

    function updateTableMasuk() {
        loadTableOnly("fetch_user/masuk", 'Anda Sudah Melakukan Absensi Masuk');
    }

    function updateTablePulang() {
        loadTableOnly("fetch_user/pulang", 'Anda Sudah Melakukan Absensi Pulang');
    }

    function updateTableAbsensi() {
        loadTableOnly("fetch_user/absensi", 'Anda Sudah Melakukan Absensi Telat');
    }

    document.getElementById("endAttendance").addEventListener("click", function() {
        stopWebcam();
        videoContainerEl.style.display = "none";
    });

    // ============================================================
    // 5. INISIALISASI
    // ============================================================
    <?php
    date_default_timezone_set('Asia/Jakarta');
    $current_time = new DateTime();
    $current_time_str = $current_time->format('H:i:s');
    $current_time_format = $current_time->format('Y-m-d H:i:s');
    ?>

    <?php if (empty($data_users)) { ?>
        // Tidak ada data user (TANPA "return" PHP, supaya 
</script> tetap tercetak)
getLocation();
<?php } else {
        $datetime_keluar_str = $tanggal_pulang_result . ' ' . $jam_keluar_plus_two;
?>
    <?php if (empty($result1) && empty($result2) && empty($result3)) { ?>
        // Case 1: belum ada absensi hari ini
        getLocation();

    <?php } else if ($current_time_str <= $jam_masuk_plus_two) { ?>
        // Case 2: sebelum batas jam masuk
        <?php if (empty($result1) && empty($result3)) { ?>
            getLocation();
        <?php } else { ?>
            updateTableMasuk();
        <?php } ?>

    <?php } else if ($current_time_str > $jam_masuk_plus_two && $current_time_str < $jam_keluar_plus_two) { ?>
        // Case 3: jendela telat
        <?php if (empty($result1) && empty($result3)) { ?>
            getLocation();
        <?php } else { ?>
            updateTableAbsensi();
        <?php } ?>

    <?php } else if ($current_time_format >= $datetime_keluar_str) { ?>
        // Case 4: waktu pulang
        <?php if (empty($result2)) { ?>
            getLocation();
        <?php } else { ?>
            updateTablePulang();
        <?php } ?>

    <?php } else { ?>
        console.log('Logic Fallback');
    <?php } ?>
<?php } ?>

// Format dengan "T" agar valid di Safari iOS
const currentTime = new Date("<?= $current_time->format('Y-m-d\TH:i:s') ?>");
console.log('Current time:', currentTime);
</script>
<script src='<?= base_url() ?>resources/assets/javascript/active_link.js'></script>