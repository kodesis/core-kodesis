<div id="page">
    <?php include 'v_nav.php' ?>
    <div class="page-content">
        <div class="card card-style shadow-xl">
            <div class="content">
                <h1 class="font-24 font-700 mb-2">
                    Welcome, <?= $user->nama ?>
                </h1>
                <p class="mb-1 font-20">
                    <?= $user->nama_jabatan ?>
                </p>
            </div>
        </div>
        <style>
            /* Kontainer utama diagram batang vertikal */
            .chart-container {
                display: flex;
                justify-content: space-around;
                align-items: flex-end;
                /* Memaksa balok rata bawah */
                height: 180px;
                /* Tinggi mutlak kontainer grafik */
                padding: 15px 10px;
                background: #f8f9fa;
                border-radius: 8px;
            }

            /* Pembungkus per satu batang status */
            .chart-bar-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 20%;
                /* Lebar tiap tiang balok */
                height: 100%;
                /* Mengambil tinggi maksimal kontainer */
                justify-content: flex-end;
            }

            /* Batang berwarna */
            .chart-bar {
                width: 100%;
                border-radius: 4px 4px 0 0;
                min-height: 4px;
                /* Tinggi minimum jika data 0% agar tetap terlihat tipis */
                transition: height 0.4s ease;
            }
        </style>
        <?php
        $open_total = $task_stats['open']['total'];

        if ($open_total > 0) {
            // 1. Hitung 3 status pertama dengan round biasa
            $p_open_prog = round(($task_stats['open']['progress'] / $open_total) * 100);
            $p_open_1wk  = round(($task_stats['open']['overdue_1wk'] / $open_total) * 100);
            $p_open_1mo  = round(($task_stats['open']['overdue_1mo'] / $open_total) * 100);

            // 2. Status terakhir dihitung dari sisa angka agar TOTAL MUTLAK 100%
            $p_open_gt   = 100 - ($p_open_prog + $p_open_1wk + $p_open_1mo);

            // Antispasasi jika hasilnya minus karena tidak ada data sama sekali di status terakhir
            if ($p_open_gt < 0) $p_open_gt = 0;
        } else {
            $p_open_prog = $p_open_1wk = $p_open_1mo = $p_open_gt = 0;
        }

        // =========================================================================
        // LAKUKAN HAL YANG SAMA UNTUK CLOSED TASKS
        // =========================================================================
        $closed_total = $task_stats['closed']['total'];

        if ($closed_total > 0) {
            $p_close_prog = round(($task_stats['closed']['progress'] / $closed_total) * 100);
            $p_close_1wk  = round(($task_stats['closed']['overdue_1wk'] / $closed_total) * 100);
            $p_close_1mo  = round(($task_stats['closed']['overdue_1mo'] / $closed_total) * 100);

            // Kunci elemen terakhir closed agar total pas 100%
            $p_close_gt   = 100 - ($p_close_prog + $p_close_1wk + $p_close_1mo);
            if ($p_close_gt < 0) $p_close_gt = 0;
        } else {
            $p_close_prog = $p_close_1wk = $p_close_1mo = $p_close_gt = 0;
        }
        ?>

        <div class="card card-style">
            <div class="content mb-0">
                <h5 class="font-14 opacity-50">Tello - Statistik Task</h5>
                <div class="divider mb-3"></div>

                <ul class="nav nav-tabs custom-tabs justify-content-center mb-4" id="taskTab" role="tablist" style="border-bottom: 2px solid #eee;">
                    <li class="nav-item w-50 text-center">
                        <button class="nav-link active w-100 font-14 font-600 pb-2" id="btn-open" type="button" onclick="switchTab('open')">
                            Open (<?= $open_total ?>)
                        </button>
                    </li>
                    <li class="nav-item w-50 text-center">
                        <button class="nav-link w-100 font-14 font-600 pb-2" id="btn-closed" type="button" onclick="switchTab('closed')">
                            Closed (<?= $closed_total ?>)
                        </button>
                    </li>
                </ul>

                <div class="tab-custom-content">

                    <div id="panel-open" class="tab-panel-item">
                        <div class="chart-container mb-4">
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_open_prog ?>%</span>
                                <div class="chart-bar bg-primary" style="height: <?= $p_open_prog ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['open']['progress'] ?>)</span>
                            </div>
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_open_1wk ?>%</span>
                                <div class="chart-bar bg-warning" style="height: <?= $p_open_1wk ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['open']['overdue_1wk'] ?>)</span>
                            </div>
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_open_1mo ?>%</span>
                                <div class="chart-bar bg-danger" style="height: <?= $p_open_1mo ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['open']['overdue_1mo'] ?>)</span>
                            </div>
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_open_gt ?>%</span>
                                <div class="chart-bar bg-dark" style="height: <?= $p_open_gt ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['open']['overdue_gt_1mo'] ?>)</span>
                            </div>
                        </div>
                    </div>

                    <div id="panel-closed" class="tab-panel-item d-none">
                        <div class="chart-container mb-4">
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_close_prog ?>%</span>
                                <div class="chart-bar bg-primary" style="height: <?= $p_close_prog ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['closed']['progress'] ?>)</span>
                            </div>
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_close_1wk ?>%</span>
                                <div class="chart-bar bg-warning" style="height: <?= $p_close_1wk ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['closed']['overdue_1wk'] ?>)</span>
                            </div>
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_close_1mo ?>%</span>
                                <div class="chart-bar bg-danger" style="height: <?= $p_close_1mo ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['closed']['overdue_1mo'] ?>)</span>
                            </div>
                            <div class="chart-bar-wrapper">
                                <span class="font-11 font-600 mb-1 text-muted"><?= $p_close_gt ?>%</span>
                                <div class="chart-bar bg-dark" style="height: <?= $p_close_gt ?>%;"></div>
                                <span class="font-10 text-muted mt-1">(<?= $task_stats['closed']['overdue_gt_1mo'] ?>)</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row g-2 text-center pb-3">
                    <div class="col-6 font-11 text-start">
                        <i class="fa fa-circle text-primary me-1"></i>
                        <span id="text-legenda-progress">On Progress</span>
                    </div>
                    <div class="col-6 font-11 text-start"><i class="fa fa-circle text-warning me-1"></i> Overdue 1 Wk</div>
                    <div class="col-6 font-11 text-start"><i class="fa fa-circle text-danger me-1"></i> Overdue 1 Wk - 1 Mo</div>
                    <div class="col-6 font-11 text-start"><i class="fa fa-circle text-dark me-1"></i> Overdue &gt; 1 Mo</div>
                </div>

            </div>
        </div>

        <script>
            function switchTab(type) {
                const legendaText = document.getElementById('text-legenda-progress');

                if (type === 'open') {
                    // 1. Toggle Active Button
                    document.getElementById('btn-open').classList.add('active');
                    document.getElementById('btn-closed').classList.remove('active');

                    // 2. Toggle Display Panel
                    document.getElementById('panel-open').classList.remove('d-none');
                    document.getElementById('panel-closed').classList.add('d-none');

                    // 3. Ubah Teks Legenda murni untuk Open
                    legendaText.innerText = "On Progress";
                } else {
                    // 1. Toggle Active Button
                    document.getElementById('btn-closed').classList.add('active');
                    document.getElementById('btn-open').classList.remove('active');

                    // 2. Toggle Display Panel
                    document.getElementById('panel-closed').classList.remove('d-none');
                    document.getElementById('panel-open').classList.add('d-none');

                    // 3. Ubah Teks Legenda murni untuk Closed
                    legendaText.innerText = "On Time";
                }
            }
        </script>
        <div class="card card-style">
            <div class="content">
                <h5 class="font-14 opacity-50">Notifications</h5>
                <div class="divider mb-3"></div>

                <div class="list-group list-custom-small list-menu ms-0 me-2">
                    <a href="<?= base_url('mobile/app/inbox') ?>" class="menu-active">
                        <i class="fa fa-envelope gradient-blue color-white"></i>
                        <span>New Memo</span>
                        <span class="badge gradient-blue color-white"><?= $memo['jumlah_memo'] ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="<?= base_url('mobile/task/task') ?>">
                        <img src="<?= base_url('assets/images/tello.png') ?>" alt="">
                        <span>Task</span>
                        <span class="badge gradient-red color-white"><?= $task['jumlah_task'] ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="<?= base_url('mobile/absensi/absen_wfa') ?>">
                        <!-- <img src="<?= base_url('assets/images/tello.png') ?>" alt=""> -->
                        <i class="gradient-blue color-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5" />
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            </svg>
                        </i>
                        <span>Absen WFA</span>
                        <!-- <span class="badge gradient-red color-white"><?= $task['jumlah_task'] ?></span> -->
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
        <a href="#" data-toggle-theme>
            <div class="card card-style">
                <div class="d-flex pt-3 mt-1 mb-2 pb-2">
                    <div class="align-self-center">
                        <i class="color-icon-gray color-gray-dark font-30 icon-40 text-center fa fa-moon ms-3 show-on-theme-light"></i>
                        <i class="color-icon-yellow color-yellow-dark font-30 icon-40 text-center fa fa-sun ms-3 show-on-theme-dark"></i>
                    </div>
                    <div class="align-self-center">
                        <p class="ps-2 ms-1 color-highlight font-500 mb-n1 mt-n2">
                            Tap to Enable
                        </p>
                        <h4 class="show-on-theme-light ps-2 ms-1 mb-0">Dark Mode</h4>
                        <h4 class="show-on-theme-dark ps-2 ms-1 mb-0">Light Mode</h4>
                    </div>
                    <div class="ms-auto align-self-center mt-n2">
                        <div class="custom-control small-switch ios-switch me-3 mt-n2">
                            <input data-toggle-theme type="checkbox" class="ios-input" id="toggle-dark-home" />
                            <label class="custom-control-label" for="toggle-dark-home"></label>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>