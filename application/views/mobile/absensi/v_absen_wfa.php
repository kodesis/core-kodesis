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
</style>
<div id="page">
    <?php include APPPATH . 'views/mobile/v_nav.php' ?>
    <div class="page-content">
        <div class="content mt-0 mb-3">
            <h3 class="text-center my-3">ABSEN WFA</h3>
            <?php

            date_default_timezone_set('Asia/Jakarta');
            $current_time = new DateTime();
            $current_time = $current_time->format('H:i:s');

            echo 'Jam Masuk :' . $jam_masuk_plus_two;
            echo 'Jam Keluar :' . $jam_keluar_plus_two;
            echo 'Jam Sekarang :' . $current_time;
            // var_dump($result3);
            var_dump($result2);
            // var_dump($result1);
            echo ('Tanggal Masuk Pulang: ' . $tanggal_pulang_result);
            ?>
            <!-- <div class="search-box shadow-xl border-0 bg-theme rounded-sm bottom-0">
                <form action="" method="get">
                    <i class="fa fa-search"></i>
                    <input type="text" class="border-0" placeholder="Fill in the subject you want to search." id="search" name="search" value="<?= strtolower($this->input->get('search') ?? '') ?>">
                </form>
            </div> -->
        </div>
        <div class="card card-style">
            <div class="content" style="cursor: pointer;">
                <div class="main--content">
                    <div id="messageDiv" class="messageDiv" style="display:none;"> </div>
                    <h5 id="lokasi_sekarang"></h5>
                    <!-- <button class="btn" id="ShowUser" onclick="getLocation()">Tampilkan Posisi</button> -->
                    <!-- <button class="btn" id="ShowUser" onclick="updateTable()">Tampilkan User</button> -->
                    <div class="attendance-button">
                        <button hidden id="startButton" class="add">Launch Facial Recognition</button>
                        <button id="endButton" class="add" style="display:none">End Attendance Process</button>
                        <button hidden id="endAttendance" class="add">END Attendance Taking</button>
                    </div>

                    <div id="konten_video" class="video-container">
                        <video id="video" class="video-class" width="320" height="240" autoplay muted></video>
                        <canvas id="overlay"></canvas>
                    </div>

                    <div class="table-container">

                        <input type="hidden" name="latitude" id="latitude_studentTable">
                        <input type="hidden" name="longitude" id="longitude_studentTable">
                        <input type="hidden" name="nama_lokasi" id="nama_lokasi">
                        <input type="hidden" name="alamat_lokasi" id="alamat_lokasi">
                        <input type="hidden" name="jam_absen" id="jam_absen">
                        <div id="studentTableContainer">

                        </div>

                    </div>
                    <p id="location"></p>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <!-- <div class="content">
            <div class="row">
                <div class="col-12 font-15">
                    <nav>
                        <?= $pagination ?>
                    </nav>
                </div>
            </div>
        </div> -->

        <!-- Button Create -->
        <!-- <a href="<?= base_url('mobile/app/create_memo') ?>" class="btn" id="btn-create"><i class="fa-solid fa-plus"></i></a> -->
    </div>
</div>
<script src="<?= base_url() ?>resources/assets/javascript/face_logics/face-api.min.js"></script>

<script src="<?= base_url() ?>assets/vendor/sweetalert2/js/sweetalert2.all.min.js"></script>

<script>
    let isWithinRange = false;
    let locationName = null;
    let AttendanceStatus = 'Absent';
    const locations = [
        <?php



        if ($lokasi_absensi) {
            foreach ($lokasi_absensi as $l) {
                if ($l['id'] == $lokasi_presensi_user->id_lokasi_presensi) { ?> {
                        name: "<?= addslashes($l['nama_lokasi']) ?>", // Ensure the name is properly escaped and quoted
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
                radius: 0.5 // Radius in kilometers
            },
            {
                name: "Parkir Bandes",
                latitude: -6.2586284,
                longitude: 106.8820789,
                radius: 0.5 // Radius in kilometers
            },
            {
                name: "Mlejit",
                latitude: -6.2638584,
                longitude: 106.8856266,
                radius: 0.5 // Radius in kilometers
            }
        <?php } ?>
    ];


    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError, {
                enableHighAccuracy: false
            });
        } else {
            Swal.fire('Error', 'Geolocation is not supported by this browser.', 'error');
        }
    }

    function showPosition(position) {
        Swal.fire({
            title: 'Loading...',
            text: 'Sedang Mencari Data Lokasi..',
            icon: 'info',
            showConfirmButton: false, // We don't want the user to click OK yet
            allowOutsideClick: false // Optional: Prevent closing by clicking outside
        });
        console.log(position);

        const userLatitude = position.coords.latitude;
        const userLongitude = position.coords.longitude;
        console.log(userLatitude);
        console.log(userLongitude);


        // Check each location
        for (const location of locations) {
            if (isWithinRadius(userLatitude, userLongitude, location.latitude, location.longitude, location.radius)) {
                isWithinRange = true;
                locationName = location.name;
                break;
            }
        }

        if (isWithinRange) {
            $('#lokasi_sekarang').text('Lokasi Sekarang ' + locationName);
            Swal.fire('Sukses', `Anda berada dalam jangkauan ${locationName}. Memperbarui tabel...`, 'success');
            updateTable(position);
        } else {
            $('#lokasi_sekarang').text('Lokasi Sekarang Di Luar Jangkauan');
            Swal.fire({
                title: 'Anda tidak berada dalam jangkauan! Ingin Tetap Absen?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Absen',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) { // Check if the confirm button was clicked
                    updateTable(position); // Execute this function only on confirmation
                }
            });
            // Swal.fire('Alert', `You are not within range. Updating table...`, 'warning');

        }
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                Swal.fire('error', 'Izin untuk mengakses lokasi ditolak.', 'error');
                break;
            case error.POSITION_UNAVAILABLE:
                Swal.fire('error', 'Informasi lokasi tidak tersedia.', 'error');
                break;
            case error.TIMEOUT:
                Swal.fire('error', 'Permintaan untuk mendapatkan lokasi Anda kehabisan waktu (timeout).', 'error');
                break;
            case error.UNKNOWN_ERROR:
                Swal.fire('error', 'Terjadi kesalahan yang tidak diketahui.', 'error');
                break;
        }
    }

    // Function to calculate distance between two coordinates
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

        const distance = earthRadiusKm * c;
        return distance <= radiusInKm;
    }

    function updateTable(position) {
        Swal.fire({
            title: 'Loading...',
            text: 'Mohon Tunggu, Sistem Sedang Mencari Data..',
            icon: 'info',
            showConfirmButton: false, // We don't want the user to click OK yet
            allowOutsideClick: false // Optional: Prevent closing by clicking outside
        });
        console.log('updateTable');
        console.log(position);

        const userLatitude = position.coords.latitude;
        const userLongitude = position.coords.longitude;
        console.log(userLatitude);
        console.log(userLongitude);

        $('#latitude_studentTable').val(userLatitude);
        $('#longitude_studentTable').val(userLongitude);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLatitude}&lon=${userLongitude}`)
            .then(response => response.json())
            .then(data => {
                const address = data.display_name || "Unknown Address";
                const name = data.address.road || "Unknown Location";

                document.getElementById('nama_lokasi').value = name;
                document.getElementById('alamat_lokasi').value = address;
            })
            .catch(error => console.error("Error fetching address:", error));

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_user", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {

                    students = response.data; // Store the student data
                    labels = students.map(student => student.username);
                    console.log(labels);
                    updateOtherElements();

                    document.getElementById("studentTableContainer").innerHTML = response.html;
                    // console.log(position);




                } else if (response.status === "No Picture") {
                    Swal.fire('Alert', 'Picture Not Found, Please take Picture first', 'warning');

                } else {
                    console.error("Error:", response.message);
                }
            }
        };

        xhr.send();
    }

    function updateTableMasuk() {
        console.log('updateTableMasuk');

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_user/masuk", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    document.getElementById("studentTableContainer").innerHTML = response.html;

                    const videoDiv = document.getElementById("konten_video");
                    videoDiv.style.display = 'none'; // Hide the div

                    students = response.data; // Store the student data
                    labels = students.map(student => student.username);
                    console.log(labels);

                } else if (response.status === "No Picture") {
                    Swal.fire('Alert', 'Picture Not Found, Please take Picture first', 'warning');

                } else {
                    console.error("Error:", response.message);
                }
            }
        };

        xhr.send();
    }

    function updateTablePulang() {
        console.log('updateTablePulang');

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_user/pulang", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    document.getElementById("studentTableContainer").innerHTML = response.html;

                    const videoDiv = document.getElementById("konten_video");
                    videoDiv.style.display = 'none'; // Hide the div

                    students = response.data; // Store the student data
                    labels = students.map(student => student.username);
                    console.log(labels);

                } else if (response.status === "No Picture") {
                    Swal.fire('Alert', 'Picture Not Found, Please take Picture first', 'warning');

                } else {
                    console.error("Error:", response.message);
                }
            }
        };

        xhr.send();
    }

    function updateTableAbsensi() {
        console.log('updateTableAbsensi');

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_user/absensi", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    document.getElementById("studentTableContainer").innerHTML = response.html;

                    const videoDiv = document.getElementById("konten_video");
                    videoDiv.style.display = 'none'; // Hide the div

                    students = response.data; // Store the student data
                    labels = students.map(student => student.username);
                    console.log(labels);

                } else if (response.status === "No Picture") {
                    Swal.fire('Alert', 'Picture Not Found, Please take Picture first', 'warning');

                } else {
                    console.error("Error:", response.message);
                }
            }
        };

        xhr.send();
    }

    function markAttendance(detectedFaces) {
        // document.querySelectorAll("#studentTableContainer tr").forEach((row) => {

        // const username = row.cells[0].innerText.trim();
        const username = document.getElementById('username').innerText; // Update attendance status

        if (detectedFaces.includes(username)) {
            if (isWithinRange) {
                document.getElementById('absent').innerText = "Present"; // Update attendance status
                document.getElementById('lokasi').innerText = locationName; // Update location
                AttendanceStatus = "Present";
            } else {
                document.getElementById('absent').innerText = "Pending"; // Update attendance status
                document.getElementById('lokasi').innerText = "Di Luar"; // Update location
                locationName = "Di Luar";
                AttendanceStatus = "Present";

            }
            const currentDate = new Date(); // Get the current date and time (UTC by default)

            // Calculate the time offset for Indonesia (UTC+7 for WIB, UTC+8 for WITA, UTC+9 for WIT)
            const indonesiaTimeOffset = 7; // Change to 8 or 9 for WITA or WIT, respectively
            const indonesiaTime = new Date(currentDate.getTime() + indonesiaTimeOffset * 60 * 60 * 1000);

            // Format the date and time as "YYYY-MM-DD HH:MM:SS"
            const formattedDateTime = indonesiaTime.toISOString().replace("T", " ").split(".")[0];

            // Format only the date as "YYYY-MM-DD"
            const formattedDateOnly = indonesiaTime.toISOString().split("T")[0];

            // Update the element with id='tanggal' to display the full date and time
            document.getElementById('tanggal').innerText = formattedDateTime;

            // Update the element with id='tanggalonly' to display only the date
            document.getElementById('tanggalonly').innerText = formattedDateOnly;

            Swal.fire('Success', `Anda Berhasil Melakukan Absensi`, 'success');
            const videoContainer = document.querySelector(".video-container");
            videoContainer.style.display = "none";

            // const capturedImage = captureImage(video);

            // const imageBox = document.createElement("div");
            // imageBox.classList.add("image-box");

            // const hiddenInput = document.createElement("input");
            // hiddenInput.type = "hidden";
            // hiddenInput.id = `image_captured`;
            // hiddenInput.name = `capturedImage`;
            // imageBox.appendChild(hiddenInput);

            // const hiddenInputs = document.getElementById(
            //     `image_captured`
            // );
            // hiddenInputs.value = capturedImage;
            const capturedImage = captureImage(video);

            sendAttendanceDataToServer(capturedImage);

            stopWebcam();

        }
        // });
    }

    function captureImage(video) {
        const canvas = document.createElement("canvas");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const context = canvas.getContext("2d");

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        return canvas.toDataURL("image/png");
    }





    function updateOtherElements() {
        const video = document.getElementById("video");
        const videoContainer = document.querySelector(".video-container");
        const startButton = document.getElementById("startButton");
        let webcamStarted = false;
        let modelsLoaded = false;
        let shift1 = <?= json_encode((bool)$shift1) ?>;
        let shift2 = <?= json_encode((bool)$shift2) ?>;
        let shift3 = <?= json_encode((bool)$shift3) ?>; // Tambahkan ini
        let buka_cam = false;

        console.log('Shift1 :' + shift1);
        console.log('Shift2 :' + shift2);


        const baseUrl = "<?php echo base_url(); ?>";

        Promise.all([
                faceapi.nets.ssdMobilenetv1.loadFromUri("https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model"),
                faceapi.nets.faceRecognitionNet.loadFromUri("https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model"),
                faceapi.nets.faceLandmark68Net.loadFromUri("https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model")
            ])
            .then(() => {
                modelsLoaded = true;
                console.log("models loaded successfully");
                videoContainer.style.display = "flex";
                if (!webcamStarted && modelsLoaded) {
                    showShiftSelection(shift1, shift2, shift3);

                    // if (shift1 && shift2) {
                    //     Swal.fire({
                    //         title: 'Pilih Jam Shift', // Judul notifikasi
                    //         text: 'Anda telah mengaktifkan lebih dari satu shift. Silakan pilih aksi yang ingin Anda lakukan:',
                    //         icon: 'question',

                    //         // 1. Tombol Konfirmasi (Default: Hijau)
                    //         showConfirmButton: true,
                    //         confirmButtonText: 'Pilih Jam Reguler',

                    //         // 2. Tombol Tolak (Default: Merah)
                    //         showDenyButton: true,
                    //         denyButtonText: 'Pilih Jam Shift 1',

                    //         // 3. Tombol Batal (Default: Abu-abu)
                    //         showCancelButton: true,
                    //         cancelButtonText: 'Pilih Jam Shift 2',

                    //         // Opsi tambahan
                    //         allowOutsideClick: false
                    //     }).then((result) => {
                    //         // Blok .then() tunggal untuk menangani semua hasil tombol

                    //         if (result.isConfirmed) {

                    //             // Aksi 1: Tombol Confirm (Pilih Jam Shift 1) diklik
                    //             // =======================================================
                    //             // result.dismiss dapat berupa 'cancel', 'backdrop', 'close', 'esc', atau 'timer'
                    //             Swal.fire('Reguler Terpilih', 'Anda memilih untuk Absen pada Jam Reguler.', 'info');

                    //             $('#jam_absen').val('reguler');


                    //         } else if (result.isDenied) {

                    //             // Aksi 2: Tombol Deny (Pilih Jam Shift 2) diklik
                    //             // =======================================================
                    //             Swal.fire('Shift 1 Terpilih!', 'Anda memilih untuk Absen pada Jam Shift 1.', 'success');
                    //             // Anda bisa menambahkan fungsi atau navigasi di sini

                    //             $('#jam_absen').val('shift1');

                    //         } else if (result.isDismissed) {

                    //             // Aksi 3: Tombol Cancel (Tutup Saja) atau Esc ditekan
                    //             // =======================================================
                    //             Swal.fire('Shift 2 Terpilih!', 'Anda memilih untuk Absen pada Jam Shift 2.', 'warning');
                    //             // Tambahkan kode untuk menonaktifkan Shift 1 atau aksi lain
                    //             $('#jam_absen').val('shift2');
                    //         }

                    //         startWebcamLogic();
                    //     });
                    // } else if (shift1) {
                    //     Swal.fire({
                    //         title: 'Pilih Jam Shift', // Judul notifikasi
                    //         text: 'Anda telah mengaktifkan lebih dari satu shift. Silakan pilih aksi yang ingin Anda lakukan:',
                    //         icon: 'question',

                    //         // 1. Tombol Konfirmasi (Default: Hijau)
                    //         showConfirmButton: true,
                    //         confirmButtonText: 'Pilih Jam Reguler',

                    //         // 2. Tombol Tolak (Default: Merah)
                    //         showDenyButton: true,
                    //         denyButtonText: 'Pilih Jam Shift 1',

                    //         // Opsi tambahan
                    //         allowOutsideClick: false
                    //     }).then((result) => {
                    //         // Blok .then() tunggal untuk menangani semua hasil tombol

                    //         if (result.isConfirmed) {

                    //             // Aksi 1: Tombol Confirm (Pilih Jam Shift 1) diklik
                    //             // =======================================================
                    //             // result.dismiss dapat berupa 'cancel', 'backdrop', 'close', 'esc', atau 'timer'
                    //             Swal.fire('Reguler Terpilih', 'Anda memilih untuk Absen pada Jam Reguler.', 'info');
                    //             $('#jam_absen').val('reguler');

                    //         } else if (result.isDenied) {

                    //             // Aksi 2: Tombol Deny (Pilih Jam Shift 2) diklik
                    //             // =======================================================
                    //             Swal.fire('Shift 1 Terpilih!', 'Anda memilih untuk Absen pada Jam Shift 1.', 'success');
                    //             // Anda bisa menambahkan fungsi atau navigasi di sini
                    //             $('#jam_absen').val('shift1');

                    //         }

                    //         startWebcamLogic();
                    //     });

                    // } else if (shift1) {
                    //     Swal.fire({
                    //         title: 'Pilih Jam Shift', // Judul notifikasi
                    //         text: 'Anda telah mengaktifkan lebih dari satu shift. Silakan pilih aksi yang ingin Anda lakukan:',
                    //         icon: 'question',

                    //         // 1. Tombol Konfirmasi (Default: Hijau)
                    //         showConfirmButton: true,
                    //         confirmButtonText: 'Pilih Jam Reguler',

                    //         // 2. Tombol Tolak (Default: Merah)
                    //         showDenyButton: true,
                    //         denyButtonText: 'Pilih Jam Shift 2',

                    //         // Opsi tambahan
                    //         allowOutsideClick: false
                    //     }).then((result) => {
                    //         // Blok .then() tunggal untuk menangani semua hasil tombol

                    //         if (result.isConfirmed) {

                    //             // Aksi 1: Tombol Confirm (Pilih Jam Shift 1) diklik
                    //             // =======================================================
                    //             // result.dismiss dapat berupa 'cancel', 'backdrop', 'close', 'esc', atau 'timer'
                    //             Swal.fire('Reguler Terpilih', 'Anda memilih untuk Absen pada Jam Reguler.', 'info');
                    //             $('#jam_absen').val('reguler');

                    //         } else if (result.isDenied) {

                    //             // Aksi 2: Tombol Deny (Pilih Jam Shift 2) diklik
                    //             // =======================================================
                    //             Swal.fire('Shift 1 Terpilih!', 'Anda memilih untuk Absen pada Jam Shift 2.', 'success');
                    //             // Anda bisa menambahkan fungsi atau navigasi di sini
                    //             $('#jam_absen').val('shift2');

                    //         }

                    //         startWebcamLogic();
                    //     });

                    // } else {
                    //     Swal.close();
                    //     $('#jam_absen').val('reguler');
                    //     startWebcamLogic();
                    // }

                    // startWebcam();
                    // webcamStarted = true;
                    // Swal.close();
                    console.log('buka_cam :' + buka_cam);

                }
            })
            .catch(() => {
                alert("models not loaded, please check your model folder location");
            });
        startButton.addEventListener("click", async () => {
            videoContainer.style.display = "flex";
            if (!webcamStarted && modelsLoaded) {
                startWebcam();
                webcamStarted = true;
            }
        });

        function showShiftSelection(shift1_active, shift2_active, shift3_active) {

            // 1. Definisikan semua opsi yang mungkin dengan label yang ramah pengguna
            const allOptions = {
                'reguler': {
                    label: 'Pilih Jam Reguler',
                    style: 'background-color: #004e81; color: white;'
                }, // Biru/Primary
                'shift1': {
                    label: 'Pilih Jam Shift 1',
                    style: 'background-color: #007da6; color: white;'
                }, // Hijau/Success
                'shift2': {
                    label: 'Pilih Jam Shift 2',
                    style: 'background-color: #38a0b7ff; color: white;'
                }, // Kuning/Warning
                'shift3': {
                    label: 'Pilih Jam Shift 3',
                    style: 'background-color: #51babaff; color: white;'
                }, // Merah/Danger
            };

            // 2. Buat array untuk shift yang benar-benar aktif/tersedia
            const activeShifts = [];
            activeShifts.push('reguler'); // Reguler diasumsikan selalu aktif
            if (shift1_active) {
                activeShifts.push('shift1');
            }
            if (shift2_active) {
                activeShifts.push('shift2');
            }
            if (shift3_active) {
                activeShifts.push('shift3');
            }
            const availableCount = activeShifts.length;

            // --- LOGIKA KONDISIONAL DINAMIS ---

            // Kasus 1: Hanya ada satu shift yang tersedia (hanya Reguler, atau hanya 1 Shift Kustom)
            if (availableCount <= 1) {
                // Karena Reguler selalu ada, jika count <= 1, maka shift yang terpilih adalah yang ada (atau 'reguler' sebagai fallback)
                const selectedShift = activeShifts[0] ?? 'reguler';

                Swal.close();
                $('#jam_absen').val(selectedShift);

                // const shiftData = allOptions[selectedShift];
                // const shiftName = shiftData.label.replace('Pilih Jam', '').trim();

                // Swal.fire({
                //     title: 'Shift Otomatis Dipilih',
                //     text: 'Hanya satu shift yang tersedia. Memilih ' + shiftName + ' secara otomatis.',
                //     icon: 'info',
                //     timer: 1500,
                //     showConfirmButton: false
                // }).then(() => {
                startWebcamLogic();
                // });
                return;
            }

            // Kasus 2: Ada lebih dari satu shift yang tersedia, tampilkan modal dengan tombol

            // Bangun HTML untuk tombol dinamis
            let buttonsHtml = '<div style="display: flex; flex-direction: column; gap: 12px; margin-top: 15px;">';

            // Tambahkan tombol untuk setiap shift aktif
            activeShifts.forEach(shiftKey => {
                const shiftData = allOptions[shiftKey];
                buttonsHtml += `
            <button 
                class="swal2-styled custom-shift-button" 
                data-shift="${shiftKey}" 
                style="${shiftData.style} font-weight: 600; padding: 12px 20px; border-radius: 8px;">
                ${shiftData.label}
            </button>
        `;
            });

            // Tambahkan tombol Batal di bagian bawah
            buttonsHtml += `
        <button 
            id="cancel-shift-selection" 
            class="swal2-styled" 
            style="background-color: #6c757d; color: white; margin-top: 10px; padding: 12px 20px; border-radius: 8px;">
            Batal Absen
        </button>
    </div>`;

            Swal.fire({
                title: 'Pilih Jam Shift',
                text: 'Anda telah mengaktifkan ' + availableCount + ' shift. Silakan pilih shift untuk absensi hari ini:',
                icon: 'question',

                // Nonaktifkan tombol bawaan SweetAlert2 dan gunakan HTML kustom
                showConfirmButton: false,
                showDenyButton: false,
                showCancelButton: false,

                html: buttonsHtml,
                allowOutsideClick: false,

                // Tambahkan event listener setelah modal terbuka
                didOpen: () => {
                    // Aksi untuk tombol Shift (Reguler, Shift 1, 2, 3)
                    document.querySelectorAll('.custom-shift-button').forEach(button => {
                        button.addEventListener('click', (e) => {
                            const selectedShift = e.currentTarget.getAttribute('data-shift');
                            // Menggunakan Swal.close() untuk mensimulasikan hasil konfirmasi
                            Swal.close({
                                isConfirmed: true,
                                value: selectedShift
                            });
                        });
                    });

                    // Aksi untuk tombol Batal
                    document.getElementById('cancel-shift-selection').addEventListener('click', () => {
                        // Menggunakan Swal.close() untuk mensimulasikan hasil batal
                        Swal.close({
                            isDismissed: true,
                            dismiss: 'cancel_button_pressed'
                        });
                    });
                }

            }).then((result) => {
                let selectedShift = '';

                // Menangkap hasil dari tombol kustom
                if (result.isConfirmed && result.value) {
                    selectedShift = result.value;

                    // Set nilai ke input tersembunyi
                    $('#jam_absen').val(selectedShift);

                    // Konfirmasi pilihan dan lanjutkan
                    const shiftData = allOptions[selectedShift];
                    const shiftName = shiftData.label.replace('Pilih Jam', '').trim();
                    Swal.fire('Shift Terpilih!', 'Anda memilih untuk Absen pada ' + shiftName + '.', 'success');

                    // Lanjutkan ke logika webcam/absensi setelah pemilihan
                    startWebcamLogic();

                } else if (result.dismiss === 'cancel_button_pressed') {
                    // Aksi jika tombol Batal Absen ditekan
                    Swal.fire('Absensi Dibatalkan', 'Anda membatalkan proses pemilihan Shift.', 'error');
                }
                // Kasus dismiss lainnya (ESC, backdrop) diabaikan
            });
        }


        function startWebcamLogic() {
            // Tutup SweetAlert sebelumnya (jika ada)
            Swal.close();

            // Periksa kondisi sebelum memulai
            if (!webcamStarted) {
                startWebcam();
                webcamStarted = true;
            }
            console.log('Webcam Started: ' + webcamStarted);
        }

        function startWebcam() {
            navigator.mediaDevices.getUserMedia({
                video: true,
                audio: false
            }).then((stream) => {
                video.srcObject = stream;
                videoStream = stream;
            }).catch((error) => {
                console.error("Error accessing webcam:", error);
                alert("Please allow webcam access.");
            });

        }

        async function getLabeledFaceDescriptions() {
            const labeledDescriptors = [];
            <?php
            // PHP part of your view
            $image_base_path = base_url('resources/labels/');
            ?>
            const BASE_IMAGE_PATH = "<?= $image_base_path ?>";

            for (const label of labels) {
                console.log(labels);
                const descriptions = [];
                // Find the student matching the username (label)
                const student = students.find(s => s.username === label);

                if (student) {
                    const nama = student.nama; // Get the student's first name
                    const username = student.username; // Get the registration number
                    for (let i = 1; i <= 5; i++) {
                        try {
                            const img = await faceapi.fetchImage(
                                // `../resources/labels/${label}/${i}.png`
                                `${BASE_IMAGE_PATH}${label}/${i}.png`

                            );
                            const detections = await faceapi
                                .detectSingleFace(img)
                                .withFaceLandmarks()
                                .withFaceDescriptor();

                            if (detections) {
                                descriptions.push(detections.descriptor);
                            } else {
                                console.log(`No face detected in ${label}/${i}.png`);
                                // Swal.fire('Alert', 'Picture Not Found, Please take Picture first', 'warning');

                            }
                        } catch (error) {

                            console.error(`Error processing ${label}/${i}.png:`, error);
                        }
                    }

                    if (descriptions.length > 0) {
                        labeledDescriptors.push(
                            new faceapi.LabeledFaceDescriptors(nama, descriptions) // Use nama here
                        );
                    }
                }
            }

            return labeledDescriptors;
        }

        video.addEventListener("play", async () => {
            const labeledFaceDescriptors = await getLabeledFaceDescriptions();
            const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);

            const canvas = faceapi.createCanvasFromMedia(video);
            videoContainer.appendChild(canvas);

            const displaySize = {
                width: video.width,
                height: video.height
            };
            faceapi.matchDimensions(canvas, displaySize);

            setInterval(async () => {
                const detections = await faceapi
                    .detectAllFaces(video)
                    .withFaceLandmarks()
                    .withFaceDescriptors();

                const resizedDetections = faceapi.resizeResults(detections, displaySize);

                canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

                const results = resizedDetections.map((d) => {
                    return faceMatcher.findBestMatch(d.descriptor);
                });

                // Now map the results to include registration numbers
                detectedFaces = results.map((result) => {
                    // We are returning the registration number instead of nama
                    const student = students.find(s => s.nama === result.label);
                    return student ? student.username : null;
                }).filter(Boolean); // Remove any null values

                console.log(detectedFaces); // Here you'll see the registration numbers
                markAttendance(detectedFaces);

                results.forEach((result, i) => {
                    const box = resizedDetections[i].detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, {
                        label: result.label, // You can keep nama as label here for visual purposes
                    });
                    drawBox.draw(canvas);
                });

            }, 100);

        });

    }

    let isSubmitting = false; // Flag to track if data is being submitted

    // function sendAttendanceDataToServer(capturedImage) {
    //     // if (isSubmitting) return; // Prevent multiple submissions

    //     // isSubmitting = true; // Set the flag to prevent re-submission

    //     const attendanceData = [];


    //     // Getting values for the attendance
    //     const username = document.getElementById('username').innerText;
    //     const nip = document.getElementById('nip').innerText;
    //     const nama = document.getElementById('nama').innerText;
    //     // const attendanceStatus = document.getElementById('absent').innerText;
    //     const attendanceStatus = AttendanceStatus;
    //     // const lokasiAttendance = document.getElementById('lokasi').innerText;
    //     const lokasiAttendance = locationName;
    //     const tanggalAttendance = document.getElementById('tanggalonly').innerText;
    //     const image = capturedImage;

    //     attendanceData.push({
    //         username,
    //         nip,
    //         nama,
    //         attendanceStatus,
    //         lokasiAttendance,
    //         image,
    //     });

    //     console.log(attendanceData);
    //     const xhr = new XMLHttpRequest();
    //     xhr.open("POST", "recordAttendance", true);
    //     xhr.setRequestHeader("Content-Type", "application/json");

    //     xhr.onreadystatechange = function() {
    //         if (xhr.readyState === 4) {
    //             isSubmitting = false; // Reset flag after request completes

    //             if (xhr.status === 200) {
    //                 try {
    //                     const response = JSON.parse(xhr.responseText);

    //                     if (response.status === "success") {
    //                         showMessage(
    //                             response.message || "Attendance recorded successfully."
    //                         );
    //                     } else {
    //                         showMessage(
    //                             response.message ||
    //                             "An error occurred while recording attendance."
    //                         );
    //                     }
    //                 } catch (e) {
    //                     showMessage("Error: Failed to parse the response from the server.");
    //                     console.error(e);
    //                 }
    //             } else {
    //                 showMessage(
    //                     "Error: Unable to record attendance. HTTP Status: " + xhr.status
    //                 );
    //                 console.error("HTTP Error", xhr.status, xhr.statusText);
    //             }
    //         }
    //     };

    //     xhr.send(JSON.stringify(attendanceData));
    // }

    function sendAttendanceDataToServer(capturedImage) {
        const attendanceData = {
            username: document.getElementById('username').innerText.trim(),
            nip: document.getElementById('nip').innerText.trim(),
            nama: document.getElementById('nama').innerText.trim(),
            attendanceStatus: AttendanceStatus,
            lokasiAttendance: locationName,
            tanggalAttendance: document.getElementById('tanggalonly').innerText.trim(),
            capturedImage: capturedImage, // Base64 encoded image data
            latitude: $('#latitude_studentTable').val(), // Base64 encoded image data
            longitude: $('#longitude_studentTable').val(), // Base64 encoded image data
            jam_absen: $('#jam_absen').val(), // Base64 encoded image data
            // nama_lokasi: $('#nama_lokasi').val(), // Base64 encoded image data
            // alamat_lokasi: $('#alamat_lokasi').val(), // Base64 encoded image data
        };

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= base_url('mobile/absensi/recordAttendance') ?>", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status == "success") {
                        Swal.fire('Success', response.message || 'Attendance recorded successfully.', 'success');
                        stopWebcam();
                    } else {
                        Swal.fire('Error', response.message || 'An error occurred while recording attendance.', 'error');
                        console.log('gagal input');
                    }
                    // } catch (e) {
                    //     Swal.fire('Error', 'Failed to parse server response.', 'error');
                    //     console.error(e);
                    // }
                } else {
                    Swal.fire('Error', `Unable to record attendance. HTTP Status: ${xhr.status}`, 'error');
                    console.error("HTTP Error", xhr.status, xhr.statusText);
                }
            }
        };

        xhr.send(JSON.stringify(attendanceData));

    }

    function showMessage(message) {
        var messageDiv = document.getElementById("messageDiv");
        messageDiv.style.display = "block";
        messageDiv.innerHTML = message;
        console.log(message);
        messageDiv.style.opacity = 1;
        setTimeout(function() {
            messageDiv.style.opacity = 0;
        }, 5000);
    }

    function stopWebcam() {
        if (videoStream) {
            const tracks = videoStream.getTracks();

            tracks.forEach((track) => {
                track.stop();
            });

            video.srcObject = null;
            videoStream = null;
        }
    }

    document.getElementById("endAttendance").addEventListener("click", function() {
        sendAttendanceDataToServer();
        const videoContainer = document.querySelector(".video-container");
        videoContainer.style.display = "none";
        stopWebcam();
    });
    <?php
    // --- Setup and Initialization (Required PHP) ---
    date_default_timezone_set('Asia/Jakarta');
    $current_time = new DateTime();

    // NOTE: PHP will crash here if $jam_masuk_plus_two and $jam_keluar_plus_two
    // are not defined or passed into the view.
    // Assuming they are passed correctly as DateTime objects.
    // Format the necessary times to H:i:s strings ONCE for reliable comparison
    // $current_time_str = $current_time->format('H:i:s');
    $current_time_str = $current_time->format('H:i:s');

    $current_time_format = $current_time->format('Y-m-d H:i:s');

    $datetime_keluar_str = $tanggal_pulang_result . ' ' . $jam_keluar_plus_two;
    // Safety check: ensure objects exist before formatting

    if (empty($data_users)) {
    ?>
        // --- JS Output for Empty User ---
        getLocation();
    <?php
        return; // Exit if no user data
    }

    // --- Centralized JavaScript Messages for clean output ---
    $loading_js = "
        getLocation();
        Swal.fire({
            title: 'Loading...',
            text: 'Sedang Mempersiapkan Lokasi..',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
        });
    ";

    $absen_masuk_js = "
        Swal.fire('Alert', 'Anda Sudah Melakukan Absensi Masuk', 'warning');
        updateTableMasuk();
    ";

    $absen_telat_js = "
        Swal.fire('Alert', 'Anda Sudah Melakukan Absensi Telat', 'warning');
        updateTableAbsensi();
    ";

    $absen_pulang_js = "
        Swal.fire('Alert', 'Anda Sudah Melakukan Absensi Pulang', 'warning');
        updateTablePulang();
    ";
    ?>


    console.log('Tes - User Data Found'); // Global Test Console Log

    <?php if (empty($result1) && empty($result2) && empty($result3)) { ?>
        // --- Case 1: No attendance recorded yet (First action of the day) ---
        console.log('ada2');
        <?php echo $loading_js; ?>

    <?php } else if ($current_time_str <= $jam_masuk_plus_two) { ?>
        // --- Case 2: Before or at entry time deadline (Masuk) ---
        console.log('Masuk');
        <?php if (empty($result1) && empty($result3)) { ?>
            console.log('result1 - Needs Masuk');
            <?php echo $loading_js; ?>
        <?php } else { ?>
            <?php echo $absen_masuk_js; ?>
        <?php } ?>

    <?php } else if ($current_time_str > $jam_masuk_plus_two && $current_time_str < $jam_keluar_plus_two) { ?>
        // --- Case 3: After entry deadline AND before exit time (Telat Window) ---
        console.log('Telat');
        <?php if (empty($result1) && empty($result3)) { ?>
            console.log('result3 - Needs Telat');
            <?php echo $loading_js; ?>
        <?php } else { ?>
            <?php echo $absen_telat_js; ?>
        <?php } ?>

    <?php } else if ($current_time_format >= $datetime_keluar_str) { ?>

        // --- Case 4: At or after exit time (Pulang) ---
        console.log('Pulang');
        <?php if (empty($result2)) { ?>
            console.log('result2s - Needs Pulang');
            <?php echo $loading_js; ?>
        <?php } else { ?>
            <?php echo $absen_pulang_js; ?>
        <?php } ?>

    <?php } else { ?>
        // --- Fallback Case (Should rarely happen with complete logic) ---
        console.log('Tes 2 - Logic Fallback');
    <?php } ?>

    const currentTime = new Date("<?php echo $current_time->format('Y-m-d H:i:s'); ?>");
    console.log('Current time:', currentTime);
</script>
<script src='<?= base_url() ?>resources/assets/javascript/active_link.js'></script>
<!-- <script src='<?= base_url() ?>resources/assets/javascript/face_logics/script.js'></script> -->